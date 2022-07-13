<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Links;
use app\models\LinksJob;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Links();
        return $this->render('index', ['model' => $model]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


    public function actionAdmin()
    {   
        $links = Links::find()->orderBy(['created_at' => SORT_DESC])->all();
        return $this->render('admin', ['links' => $links]);
    }

    public function actionCheck()
    {
        $model = new Links();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            $url = $model->link;
            $repeating = $model->repeating;
            $period = $model->period;
            $model->created_at = (new \DateTime('now', new \DateTimeZone('Europe/Moscow')))->format('Y-m-d H:i:s');
            $model->save();

            $id = $model->id;

            if (Yii::$app->queue->delay(5)->push(new LinksJob([
                'id' => $id,
                'link' => $url,
                'repeating' => $repeating,
                'period' => $period,               
            ]))) {               
                $status = "Проверяем $url";
                return $this->render('index', ['model' => $model, 'status' => $status]);
            } else {
                $status = "Ошибка проверки $url";
                return $this->render('index', ['model' => $model, 'status' => $status]);
            }
        } else {
            return $this->render('index', ['model' => $model]);
        }
    }
}

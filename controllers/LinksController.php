<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Links;
use app\helpers\MyHelper;

use app\models\LinksJob;
 
class LinksController extends Controller
{   
    public function actionIndex()
    {   
        $model = new Links();
        return $this->render('index', ['model' => $model]);
    }
 
    public function actionCheck()
    {
        $model = new Links();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            $url = $model->link;
            $repeating = $model->repeating;
            $period = $model->period;

            $status = "Проверяем $url";

            $result = MyHelper::checkLink($url);
            
            $httpCode = $result['httpCode'];

            if (Yii::$app->queue->delay(10)->push(new LinksJob([
                'link' => $url,
                'repeating' => $repeating,
                'period' => $period,
                'http' => $httpCode,
                'created_at'=> (new \DateTime('now', new \DateTimeZone('Europe/Moscow')))->format('Y-m-d H:i:s'),
            ]))) {                
                $queue = Yii::$app->queue; 
                $queue->run(false);                
                return $this->render('index', ['model' => $model, 'status' => $status]);
            } else {
                $status = "Ошибка проверки $url";
                return $this->render('index', ['model' => $model, 'status' => $status]);
            }
        } 
        else {
            return $this->render('index', ['model' => $model]);
        }
    }
 
}
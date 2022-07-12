<?php

namespace app\models;

use yii\base\BaseObject;
use Yii;

 
class LinksJob extends BaseObject implements \yii\queue\JobInterface
{
    public $link;
    public $repeating;
    public $period;
    public $http;
    public $created_at;
    public $attempt;

    public function execute($queue) 
    {            
        Yii::$app->db->createCommand()->insert(
            'links', [
                'link' => $this->link,
                'repeating' => $this->repeating,
                'period' => $this->period,
                'http' => $this->http,
                'created_at' => $this->created_at,
                'attempt' => $this->attempt,
                'checked_at' => (new \DateTime('now', new \DateTimeZone('Europe/Moscow')))->format('Y-m-d H:i:s'),
            ]
        )->execute();        
    } 
}
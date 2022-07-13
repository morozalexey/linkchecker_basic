<?php

namespace app\models;

use yii\base\BaseObject;
use app\helpers\MyHelper;
use Yii;
 
class LinksJob extends BaseObject implements \yii\queue\JobInterface
{   
    public $id;
    public $link;
    public $repeating;
    public $period;
            
    public function execute($queue) 
    {     
        for ($i=1; $i <= $this->repeating ; $i++) { 
            $result = MyHelper::checkLink($this->link);    
                    
            $httpCode = $result['httpCode'];
            
            $checked_at = (new \DateTime('now', new \DateTimeZone('Europe/Moscow')))->format('Y-m-d H:i:s');
            
            Yii::$app->db->createCommand("UPDATE `links` SET `http`=:column1, `checked_at`=:column2, `attempt`=:column3 WHERE id=:id")
            ->bindValue(':id', $this->id)
            ->bindValue(':column1', $httpCode)
            ->bindValue(':column2', $checked_at)
            ->bindValue(':column3', $i)
            ->execute();

            if ($httpCode != 200) {
                sleep(10);
            }
        }       
    } 
}
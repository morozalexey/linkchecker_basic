<?php 

namespace app\models;
use yii\db\ActiveRecord;

//class Links extends Model
class Links extends ActiveRecord
{
    public function rules()
    {
        return [
            [['link', 'repeating', 'period'], 'required'],
        ];
    }
 
}
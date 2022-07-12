<?php

use yii\db\Migration;

/**
 * Class m220709_172542_links
 */
class m220709_172542_links extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220709_172542_links cannot be reverted.\n";

        return false;
    }

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('{{%links}}', [
            'id' => $this->primaryKey(),
            'link' => $this->string(),
            'repeating' =>  $this->integer(),
            'period'  => $this->integer(),
            'http'  => $this->string(),
            'attempt' => $this->integer(),
            'created_at' => $this->dateTime(),
            'checked_at' => $this->dateTime()
        ]);
    }

    public function down()
    {
        echo "m220709_172542_links cannot be reverted.\n";

        return false;
    }
    
}

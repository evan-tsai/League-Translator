<?php

use yii\db\Migration;

class m170602_081953_champions extends Migration
{
    public $tableName = '{{%champions}}';
    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'champion_id' => $this->integer()->notNull()->unique(),
            'english' => $this->string(32)->notNull()->unique(),
            'english_title' => $this->string(32),
            'taiwan' => $this->string(32),
            'taiwan_title' => $this->string(32),
            'china' => $this->string(32),
            'china_title' => $this->string(32),
            'korea' => $this->string(32),
            'korea_title' => $this->string(32),
            'japan' => $this->string(32),
            'japan_title' => $this->string(32),
        ], 'ENGINE=InnoDB');
    }

    public function down()
    {
        echo "m170602_081953_champions cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}

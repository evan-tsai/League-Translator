<?php

use yii\db\Migration;

class m170603_083546_champion_spells extends Migration
{
    public $tableName = '{{%champion_spells}}';
    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'champion_id' => $this->integer()->notNull()->unique(),
            'english_passive' => $this->string(32),
            'english_q' => $this->string(32),
            'english_w' => $this->string(32),
            'english_e' => $this->string(32),
            'english_r' => $this->string(32),
            'taiwan_passive' => $this->string(32),
            'taiwan_q' => $this->string(32),
            'taiwan_w' => $this->string(32),
            'taiwan_e' => $this->string(32),
            'taiwan_r' => $this->string(32),
            'china_passive' => $this->string(32),
            'china_q' => $this->string(32),
            'china_w' => $this->string(32),
            'china_e' => $this->string(32),
            'china_r' => $this->string(32),
            'korea_passive' => $this->string(32),
            'korea_q' => $this->string(32),
            'korea_w' => $this->string(32),
            'korea_e' => $this->string(32),
            'korea_r' => $this->string(32),
            'japan_passive' => $this->string(32),
            'japan_q' => $this->string(32),
            'japan_w' => $this->string(32),
            'japan_e' => $this->string(32),
            'japan_r' => $this->string(32),
        ], 'ENGINE=InnoDB');
    }

    public function down()
    {
        echo "m170603_083546_champion_spells cannot be reverted.\n";

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

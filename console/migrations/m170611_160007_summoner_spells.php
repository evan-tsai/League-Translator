<?php

use yii\db\Migration;

class m170611_160007_summoner_spells extends Migration
{
    public $tableName = '{{%summoner_spells}}';
    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'spell_id' => $this->integer()->notNull()->unique(),
            'english' => $this->string(32)->notNull()->unique(),
            'taiwan' => $this->string(32),
            'china' => $this->string(32),
            'korea' => $this->string(32),
            'japan' => $this->string(32),
        ], 'ENGINE=InnoDB');
    }

    public function down()
    {
        echo "m170611_160007_summoner_spells cannot be reverted.\n";

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

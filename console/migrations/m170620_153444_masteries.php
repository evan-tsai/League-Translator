<?php

use yii\db\Migration;

class m170620_153444_masteries extends Migration
{
    public $tableName = '{{%masteries}}';
    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'mastery_id' => $this->integer()->notNull()->unique(),
            'type' => $this->integer()->notNull(),
            'english' => $this->string(32),
            'taiwan' => $this->string(32),
            'china' => $this->string(32),
            'korea' => $this->string(32),
            'japan' => $this->string(32),
        ], 'ENGINE=InnoDB');
    }

    public function down()
    {
        echo "m170620_153444_masteries cannot be reverted.\n";

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

<?php

use yii\db\Migration;

class m170607_085006_item_map extends Migration
{
    public $tableName = '{{%item_map}}';
    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer()->notNull(),
            'map_id' => $this->integer()->notNull()
        ], 'ENGINE=InnoDB');
    }

    public function down()
    {
        echo "m170607_085006_item_map cannot be reverted.\n";

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

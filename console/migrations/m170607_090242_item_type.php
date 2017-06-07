<?php

use yii\db\Migration;

class m170607_090242_item_type extends Migration
{
    public $tableName = '{{%item_type}}';
    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer()->notNull(),
            'subtype_id' => $this->integer()->notNull(),
        ], 'ENGINE=InnoDB');
    }

    public function down()
    {
        echo "m170607_090242_item_type cannot be reverted.\n";

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

<?php

use yii\db\Migration;

class m170607_090140_item_subtype_list extends Migration
{
    public $tableName = '{{%item_subtype_list}}';
    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'subtype_id' => $this->integer()->notNull()->unique(),
            'type_id' => $this->integer()->notNull(),
            'english' => $this->string(32),
            'taiwan' => $this->string(32),
            'china' => $this->string(32),
            'korea' => $this->string(32),
            'japan' => $this->string(32),
        ], 'ENGINE=InnoDB');
    }


    public function down()
    {
        echo "m170607_090140_item_subtype_list cannot be reverted.\n";

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

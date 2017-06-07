<?php

use yii\db\Migration;

class m170607_085124_item_type_list extends Migration
{
    public $tableName = '{{%item_type_list}}';
    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer()->notNull()->unique(),
            'english' => $this->string(32),
            'taiwan' => $this->string(32),
            'china' => $this->string(32),
            'korea' => $this->string(32),
            'japan' => $this->string(32),
        ], 'ENGINE=InnoDB');
    }

    public function down()
    {
        echo "m170607_085124_item_type_list cannot be reverted.\n";

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

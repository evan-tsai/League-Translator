<?php

use yii\db\Migration;

class m170612_084136_settings extends Migration
{
    public $tableName = '{{%settings}}';

    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id'             => $this->primaryKey(),
            'property_name'  => $this->string(20)->notNull(),
            'property_key'   => $this->string(40)->unique()->notNull(),
            'property_val'   => $this->string(30),
        ], 'ENGINE=InnoDB');
        $this->insert($this->tableName, [
            'property_name' => 'version',
            'property_key' => 'api.version',
        ]);
    }

    public function safeDown()
    {
        echo "m170612_084136_settings cannot be reverted.\n";

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

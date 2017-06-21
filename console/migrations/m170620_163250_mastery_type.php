<?php

use yii\db\Migration;

class m170620_163250_mastery_type extends Migration
{
    public $tableName = '{{%mastery_type}}';
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer()->notNull(),
            'english' => $this->string(32),
            'taiwan' => $this->string(32),
            'china' => $this->string(32),
            'korea' => $this->string(32),
            'japan' => $this->string(32),
        ], 'ENGINE=InnoDB');
        $this->batchInsert($this->tableName,
            ['id', 'type_id', 'english',],
            [
                [1, 1, 'Ferocity'],
                [2, 2, 'Resolve'],
                [3, 3, 'Cunning'],
            ]
        );
    }

    public function safeDown()
    {
        echo "m170620_163250_mastery_type cannot be reverted.\n";

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

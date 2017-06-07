<?php

use yii\db\Migration;

class m170607_090140_item_subtype_list extends Migration
{
    public $tableName = '{{%item_subtype_list}}';
    public function safeUp()
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
        $this->batchInsert($this->tableName,
            ['subtype_id', 'type_id', 'english',],
            [
                [1, 1, 'Lane'],
                [2, 1, 'Jungle'],
                [3, 2, 'Gold Per'],
                [4, 2, 'Consumable'],
                [5, 2, 'Vision'],
                [6, 3, 'Health'],
                [7, 3, 'Health Regen'],
                [8, 3, 'Armor'],
                [9, 3, 'Spell Block'],
                [10, 4, 'Life Steal'],
                [11, 4, 'Critical Strike'],
                [12, 4, 'Attack Speed'],
                [13, 4, 'Damage'],
                [14, 5, 'Mana'],
                [15, 5, 'Spell Damage'],
                [16, 5, 'Cooldown Reduction'],
                [17, 5, 'Mana Regen'],
                [18, 6, 'Boots'],
                [19, 6, 'Non Boots Movement'],
                [20, 7, 'Active'],
                [21, 7, 'Spell Vamp'],
                [22, 7, 'Magic Penetration'],
                [23, 7, 'Armor Penetration'],
                [24, 7, 'Aura'],
                [25, 7, 'On Hit'],
                [26, 7, 'Trinket'],
                [27, 7, 'Slow'],
                [28, 7, 'Stealth'],
                [29, 7, 'Tenacity'],
            ]
        );
    }


    public function safeDown()
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

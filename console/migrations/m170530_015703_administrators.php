<?php

use yii\db\Migration;

class m170530_015703_administrators extends Migration
{
    public $tableName = '{{%administrators}}';
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'email' => $this->string(40),
            'auth_key' => $this->string(32)->notNull(),
            'password_salt' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'last_logon_ip' => $this->string(40)->defaultValue('0.0.0.0'),
            'last_logon_time' => $this->integer()->defaultValue(0),
        ], 'ENGINE=InnoDB');
        $this->insert($this->tableName, [
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password_salt' => Yii::$app->security->generatePasswordHash('123456'),
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'last_logon_ip' => '0.0.0.0',
            'last_logon_time' => time(),
        ]);

    }

    public function safeDown()
    {
        echo "m170530_015703_administrators cannot be reverted.\n";

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

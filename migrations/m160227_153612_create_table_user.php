<?php

use yii\db\Schema;
use yii\db\Migration;

class m160227_153612_create_table_user extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        //Пользователи
        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'email' => Schema::TYPE_STRING . "(500) NOT NULL COMMENT 'E-mail'",
            'password' => Schema::TYPE_STRING . "(500) NOT NULL COMMENT 'Пароль'",          
            'surname' => Schema::TYPE_STRING . "(500) NULL COMMENT 'Фамилия'",
            'name' => Schema::TYPE_STRING . "(500) NULL COMMENT 'Имя'",
            'patronymic' => Schema::TYPE_STRING . "(500) NULL COMMENT 'Отчество'",
            'phone' => Schema::TYPE_STRING . "(500) NULL COMMENT 'Телефон'",
            'hash' => Schema::TYPE_STRING . "(500) NULL COMMENT 'Токен'",
            'is_active' => Schema::TYPE_INTEGER . " NOT NULL DEFAULT 0 COMMENT 'Активирован'",
        ], $tableOptions);  

        $this->insert('{{%user}}', [
            'email' => 'admin',
            'password' => 'admin',
        ]);      
        
    }
    
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}

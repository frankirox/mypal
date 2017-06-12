<?php

use yii\db\Migration;

class m150703_182055_create_auth_table extends Migration
{

    const TABLE_NAME = '{{%auth}}';
    
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'source' => $this->string(255)->notNull(),
            'source_id' => $this->string(255)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_auth_user', self::TABLE_NAME, 'user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_auth_user', self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}

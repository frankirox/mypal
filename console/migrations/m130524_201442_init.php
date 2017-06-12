<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    const USER_TABLE = '{{%user}}';
    const PROFILE_TABLE = '{{%profile}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::USER_TABLE, [
            'id' => $this->primaryKey()->unsigned(),
            'superadmin' => $this->boolean()->unsigned()->notNull()->defaultValue(false),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'email_confirmed' => $this->boolean()->unsigned()->notNull()->defaultValue(false),
            'confirmation_token' => $this->string(255),
            'status' => $this->smallInteger(2)->notNull()->defaultValue(10),
            'bind_to_ip' => $this->string(255),
            'registration_ip' => $this->string(15),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned(),
        ], $tableOptions);


        $this->createTable(self::PROFILE_TABLE, [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'gender' => $this->string(1)->notNull()->defaultValue(''),
            'first_name' => $this->string(255)->notNull(),
            'last_name' => $this->string(255)->notNull(),
            'country' => $this->string(255)->notNull(),
            'language' => $this->string(6)->notNull(),
            'timezone' => $this->string(64)->notNull(),
            'avatar' => $this->text(),
            'created_at' => $this->integer(11)->unsigned()->notNull(),
            'updated_at' => $this->integer(11)->unsigned(),
            'created_by' => $this->integer(11)->unsigned(),
            'updated_by' => $this->integer(11)->unsigned(),
        ], $tableOptions);


        $this->createIndex('user_id_index', self::PROFILE_TABLE, 'user_id');
        $this->addForeignKey('fk_profile_user_id_user_id', self::PROFILE_TABLE, 'user_id', self::USER_TABLE, 'id',
            'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropTable(self::USER_TABLE);
        $this->dropForeignKey('fk_profile_user_id_user_id', self::PROFILE_TABLE);
        $this->dropTable(self::PROFILE_TABLE);
        $this->dropForeignKey('fk_user_access_token_user_id', self::USER_ACCESS_TOKEN_TABLE);
    }
}


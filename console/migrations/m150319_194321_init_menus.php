<?php

use yii\db\Migration;

class m150319_194321_init_menus extends Migration
{

    const TABLE_NAME = '{{%menu}}';
    const TABLE_LANG_NAME = '{{%menu_lang}}';
    const TABLE_LINK_NAME = '{{%menu_link}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->string(64)->notNull(),
            'custom' => $this->text()->comment('used to store serialized attributes'),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned(),
            'created_by' => $this->integer()->unsigned(),
            'updated_by' => $this->integer()->unsigned(),
        ], $tableOptions);

        $this->addPrimaryKey('pk_menu_table', self::TABLE_NAME, 'id');
        $this->addForeignKey('fk_menu_created_by', self::TABLE_NAME, 'created_by', '{{%user}}', 'id', 'SET NULL',
            'CASCADE');
        $this->addForeignKey('fk_menu_updated_by', self::TABLE_NAME, 'updated_by', '{{%user}}', 'id', 'SET NULL',
            'CASCADE');

        $this->createTable(self::TABLE_LINK_NAME, [
            'id' => $this->string(64)->notNull(),
            'menu_id' => $this->string(64)->notNull(),
            'link' => $this->string(255),
            'parent_id' => $this->string(64)->defaultValue(''),
            'image' => $this->string(24),
            'alwaysVisible' => $this->boolean()->unsigned()->notNull()->defaultValue(false),
            'permissions' => $this->string(255),
            'order' => $this->integer(),
            'custom' => $this->text()->comment('used to store serialized attributes'),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned(),
            'created_by' => $this->integer()->unsigned(),
            'updated_by' => $this->integer()->unsigned(),
        ], $tableOptions);

        $this->addPrimaryKey('pk_menu_link_table', self::TABLE_LINK_NAME, 'id');
        $this->createIndex('link_menu_id', self::TABLE_LINK_NAME, 'menu_id');
        $this->createIndex('link_parent_id', self::TABLE_LINK_NAME, 'parent_id');
        $this->addForeignKey('fk_menu_link_created_by', self::TABLE_LINK_NAME, 'created_by', '{{%user}}', 'id',
            'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_menu_link_updated_by', self::TABLE_LINK_NAME, 'updated_by', '{{%user}}', 'id',
            'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_menu_link', self::TABLE_LINK_NAME, 'menu_id', self::TABLE_NAME, 'id', 'CASCADE');


        $this->createTable(self::TABLE_LANG_NAME, [
            'id' => $this->primaryKey()->unsigned(),
            'menu_id' => $this->string(64),
            'link_id' => $this->string(64),
            'language' => $this->string(6)->notNull(),
            'title' => $this->string(255),
            'label' => $this->string(255),
        ], $tableOptions);

        $this->createIndex('menu_lang_language', self::TABLE_LANG_NAME, 'language');

        $this->createIndex('menu_lang_post_id', self::TABLE_LANG_NAME, 'menu_id');

        $this->addForeignKey('fk_menu_lang', self::TABLE_LANG_NAME, 'menu_id', self::TABLE_NAME, 'id', 'CASCADE',
            'CASCADE');

        $this->createIndex('menu_link_lang_link_id', self::TABLE_LANG_NAME, 'link_id');
        $this->addForeignKey('fk_menu_link_lang', self::TABLE_LANG_NAME, 'link_id', self::TABLE_LINK_NAME, 'id',
            'CASCADE', 'CASCADE');

        $this->insert(self::TABLE_NAME,
            ['id' => 'admin-menu', 'created_by' => 1, 'created_at' => 0, 'updated_at' => 0]);
        $this->insert(self::TABLE_LANG_NAME,
            ['menu_id' => 'admin-menu', 'language' => 'en-US', 'title' => 'Control Panel Menu']);
        $this->insert(self::TABLE_LANG_NAME,
            ['menu_id' => 'admin-menu', 'language' => 'es-ES', 'title' => 'Menú del panel de control']);

    }

    public function down()
    {
        $this->dropForeignKey('fk_menu_created_by', self::TABLE_NAME);
        $this->dropForeignKey('fk_menu_updated_by', self::TABLE_NAME);
        $this->dropForeignKey('fk_menu_link_created_by', self::TABLE_LINK_NAME);
        $this->dropForeignKey('fk_menu_link_updated_by', self::TABLE_LINK_NAME);

        $this->dropForeignKey('fk_menu_link_lang', self::TABLE_LINK_NAME);
        $this->dropForeignKey('fk_menu_link', self::TABLE_LINK_NAME);
        $this->dropForeignKey('fk_menu_lang', self::TABLE_LANG_NAME);

        $this->dropTable(self::TABLE_LINK_NAME);
        $this->dropTable(self::TABLE_LANG_NAME);
        $this->dropTable(self::TABLE_NAME);
    }

}


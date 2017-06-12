<?php

use yii\db\Migration;

class m150719_154955_add_setting_menu_links extends Migration
{

    public function up()
    {
        $this->insert('{{%menu_link}}', [
            'id' => 'settings',
            'menu_id' => 'admin-menu',
            'image' => 'cog',
            'created_by' => 1,
            'order' => 20,
            'created_at' => 0,
            'updated_at' => 0,
            'permissions' => 'changeGeneralSettings'
        ]);
        $this->insert('{{%menu_link}}', [
            'id' => 'settings-general',
            'menu_id' => 'admin-menu',
            'link' => '/settings/default/index',
            'parent_id' => 'settings',
            'created_by' => 1,
            'order' => 1,
            'created_at' => 0,
            'updated_at' => 0,
            'permissions' => 'changeGeneralSettings'
        ]);
        $this->insert('{{%menu_link}}', [
            'id' => 'settings-reading',
            'menu_id' => 'admin-menu',
            'link' => '/settings/reading/index',
            'parent_id' => 'settings',
            'created_by' => 1,
            'order' => 4,
            'created_at' => 0,
            'updated_at' => 0,
            'permissions' => 'changeReadingSettings'
        ]);
        $this->insert('{{%menu_link}}', [
            'id' => 'settings-cache',
            'menu_id' => 'admin-menu',
            'link' => '/settings/cache/flush',
            'parent_id' => 'settings',
            'created_by' => 1,
            'order' => 99,
            'created_at' => 0,
            'updated_at' => 0,
            'permissions' => 'flushCache'
        ]);

        $this->insert('{{%menu_lang}}', ['link_id' => 'settings', 'label' => 'Settings', 'language' => 'en-US']);
        $this->insert('{{%menu_lang}}', ['link_id' => 'settings', 'label' => 'Ajustes', 'language' => 'es-ES']);
        $this->insert('{{%menu_lang}}',
            ['link_id' => 'settings-general', 'label' => 'General Settings', 'language' => 'en-US']);
        $this->insert('{{%menu_lang}}',
            ['link_id' => 'settings-general', 'label' => 'Ajustes generales', 'language' => 'es-ES']);
        $this->insert('{{%menu_lang}}',
            ['link_id' => 'settings-reading', 'label' => 'Reading Settings', 'language' => 'en-US']);
        $this->insert('{{%menu_lang}}',
            ['link_id' => 'settings-reading', 'label' => 'Ajustes de lectura', 'language' => 'es-ES']);
        $this->insert('{{%menu_lang}}',
            ['link_id' => 'settings-cache', 'label' => 'Flush Cache', 'language' => 'en-US']);
        $this->insert('{{%menu_lang}}',
            ['link_id' => 'settings-cache', 'label' => 'Limpiar Cache', 'language' => 'es-ES']);


    }

    public function down()
    {
        $this->delete('{{%menu_link}}', ['like', 'id', 'settings-cache']);
        $this->delete('{{%menu_link}}', ['like', 'id', 'settings-general']);
        $this->delete('{{%menu_link}}', ['like', 'id', 'settings']);
        $this->delete('{{%menu_link}}', ['like', 'id', 'settings-reading']);
    }
}

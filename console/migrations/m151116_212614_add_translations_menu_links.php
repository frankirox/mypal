<?php

use yii\db\Migration;

class m151116_212614_add_translations_menu_links extends Migration
{

    public function up()
    {
        $this->insert('{{%menu_link}}', [
            'id' => 'settings-translations',
            'menu_id' => 'admin-menu',
            'link' => '/translation/default/index',
            'parent_id' => 'settings',
            'created_by' => 1,
            'order' => 5,
            'created_at' => 0,
            'updated_at' => 0
        ]);

        $this->insert('{{%menu_lang}}',
            ['link_id' => 'settings-translations', 'label' => 'Translations', 'language' => 'en-US']);
        $this->insert('{{%menu_lang}}',
            ['link_id' => 'settings-translations', 'label' => 'Traducciones', 'language' => 'es-ES']);

    }

    public function down()
    {
        $this->delete('{{%menu_link}}', ['like', 'id', 'settings-translations']);
    }
}
<?php

use yii\db\Migration;

class m150729_122614_add_pet_menu_links extends Migration
{

    public function up()
    {

        $this->insert('{{%menu_link}}', [
            'id' => 'pets',
            'menu_id' => 'admin-menu',
            'image' => 'pencil',
            'link' => '/pet/default/index',
            'created_by' => 1,
            'order' => 3,
            'created_at' => 0,
            'updated_at' => 0,
            'permissions' => 'viewPets'
        ]);
        $this->insert('{{%menu_lang}}', ['link_id' => 'pets', 'label' => 'Pets', 'language' => 'en-US']);
        $this->insert('{{%menu_lang}}', ['link_id' => 'pets', 'label' => 'Mascotas', 'language' => 'es-ES']);
    }

    public function down()
    {
        $this->delete('{{%menu_link}}', ['like', 'id', 'pets']);
    }
}

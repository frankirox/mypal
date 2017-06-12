<?php

use yii\db\Migration;

class m150729_121634_add_user_menu_links extends Migration
{

    public function up()
    {
        $this->insert('{{%menu_link}}', ['id' => 'user', 'menu_id' => 'admin-menu', 'image' => 'user', 'created_by' => 1, 'order' => 15, 'created_at' => 0, 'updated_at' => 0, 'permissions' => 'viewUsers']);
        $this->insert('{{%menu_link}}', ['id' => 'user-groups', 'menu_id' => 'admin-menu', 'link' => '/user/permission-groups/index', 'parent_id' => 'user', 'created_by' => 1, 'order' => 4, 'created_at' => 0, 'updated_at' => 0, 'permissions' => 'viewRolesAndPermissions']);
        $this->insert('{{%menu_link}}', ['id' => 'user-log', 'menu_id' => 'admin-menu', 'link' => '/user/visit-log/index', 'parent_id' => 'user', 'created_by' => 1, 'order' => 10, 'created_at' => 0, 'updated_at' => 0, 'permissions' => 'viewVisitLog']);
        $this->insert('{{%menu_link}}', ['id' => 'user-permission', 'menu_id' => 'admin-menu', 'link' => '/user/permission/index', 'parent_id' => 'user', 'created_by' => 1, 'order' => 3, 'created_at' => 0, 'updated_at' => 0, 'permissions' => 'viewRolesAndPermissions']);
        $this->insert('{{%menu_link}}', ['id' => 'user-role', 'menu_id' => 'admin-menu', 'link' => '/user/role/index', 'parent_id' => 'user', 'created_by' => 1, 'order' => 2, 'created_at' => 0, 'updated_at' => 0, 'permissions' => 'viewRolesAndPermissions']);
        $this->insert('{{%menu_link}}', ['id' => 'user-user', 'menu_id' => 'admin-menu', 'link' => '/user/default/index', 'parent_id' => 'user', 'created_by' => 1, 'order' => 1, 'created_at' => 0, 'updated_at' => 0, 'permissions' => 'viewUsers']);

        $this->insert('{{%menu_lang}}', ['link_id' => 'user', 'label' => 'Users', 'language' => 'en-US']);
        $this->insert('{{%menu_lang}}', ['link_id' => 'user', 'label' => 'Usuarios', 'language' => 'es-ES']);
        $this->insert('{{%menu_lang}}', ['link_id' => 'user-groups', 'label' => 'Permission groups', 'language' => 'en-US']);
        $this->insert('{{%menu_lang}}', ['link_id' => 'user-groups', 'label' => 'Grupos de permisos', 'language' => 'es-ES']);
        $this->insert('{{%menu_lang}}', ['link_id' => 'user-log', 'label' => 'Visit log', 'language' => 'en-US']);
        $this->insert('{{%menu_lang}}', ['link_id' => 'user-log', 'label' => 'Historial de visitas', 'language' => 'es-ES']);
        $this->insert('{{%menu_lang}}', ['link_id' => 'user-permission', 'label' => 'Permissions', 'language' => 'en-US']);
        $this->insert('{{%menu_lang}}', ['link_id' => 'user-permission', 'label' => 'Permisos', 'language' => 'es-ES']);
        $this->insert('{{%menu_lang}}', ['link_id' => 'user-role', 'label' => 'Roles', 'language' => 'en-US']);
        $this->insert('{{%menu_lang}}', ['link_id' => 'user-role', 'label' => 'Roles', 'language' => 'es-ES']);
        $this->insert('{{%menu_lang}}', ['link_id' => 'user-user', 'label' => 'Users', 'language' => 'en-US']);
        $this->insert('{{%menu_lang}}', ['link_id' => 'user-user', 'label' => 'Usuarios', 'language' => 'es-ES']);

    }

    public function down()
    {

        $this->delete('{{%menu_link}}', ['like', 'id', 'user-user']);
        $this->delete('{{%menu_link}}', ['like', 'id', 'user-role']);
        $this->delete('{{%menu_link}}', ['like', 'id', 'user-permission']);
        $this->delete('{{%menu_link}}', ['like', 'id', 'user-log']);
        $this->delete('{{%menu_link}}', ['like', 'id', 'user-groups']);
        $this->delete('{{%menu_link}}', ['like', 'id', 'user']);
    }
}


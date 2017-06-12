<?php

use common\db\TranslatedMessagesMigration;

class m160711_003200_miranda_user_spanish_translations extends TranslatedMessagesMigration
{
    public function getLanguage()
    {
        return 'es-ES';
    }

    public function getCategory()
    {
        return 'miranda/user';
    }

    public function getTranslations()
    {
        return [
            'Child permissions' => 'Permisos hijos',
            'Child roles' => 'Roles hijos',
            'Create Permission Group' => 'Crear grupo de permisos',
            'Create Permission' => 'Crear permiso',
            'Create Role' => 'Crear Rol',
            'Create User' => 'Crear Usuario',
            'Log №{id}' => 'Registro №{id}',
            'No users found.' => 'No se encontraron usuarios',
            'Password' => 'Contraseña',
            'Permission Groups' => 'Grupos de permisos',
            'Permission' => 'Permiso',
            'Permissions for "{role}" role' => 'Permisos para el rol "{role}"',
            'Permissions' => 'Permisos',
            'Please confirm your email address by clicking the link below:' => 'Siga el enlace para confirmar su direccion de email:',
            'Refresh routes' => 'Actualizar rutas',
            'Registration date' => 'Fecha de registro',
            'Role' => 'Rol',
            'Roles and Permissions for "{user}"' => 'Roles y permisos para el usuario "{user}"',
            'All Roles' => 'Todos los roles',
            'Roles' => 'Roles',
            'Routes' => 'Rutas',
            'Search route' => 'Buscar ruta',
            'Show all' => 'Mostrar todo',
            'Show only selected' => 'Show only selected',
            'Update Permission Group' => 'Actualizar grupo de permisos',
            'Update Permission' => 'Actualizar permiso',
            'Update Role' => 'Actualizar rol',
            'Update User Password' => 'Actualizar contraseña de usuario',
            'Update User' => 'Actualizar usuario',
            'User not found' => 'Usuario no encontrado',
            'User' => 'Usuario',
            'Users' => 'Usuarios',
            'Visit Log' => 'Historial de visitas',
            'You can not change own permissions' => 'No puede cambiar sus propios permisos',
            "You can't update own permissions!" => 'No puede cambiar sus propios permisos',
            '{permission} Permission Settings' => 'Ajustes del permiso "{permission}"',
            '{permission} Role Settings' => 'Ajustes del rol "{permission}"',
        ];
    }
}

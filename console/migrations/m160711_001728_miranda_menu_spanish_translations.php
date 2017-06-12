<?php

use common\db\TranslatedMessagesMigration;

class m160711_001728_miranda_menu_spanish_translations extends TranslatedMessagesMigration
{

    public function getLanguage()
    {
        return 'es-ES';
    }

    public function getCategory()
    {
        return 'miranda/menu';
    }

    public function getTranslations()
    {
        return [
            'Menu' => 'Menú',
            'Menus' => 'Menús',
            'Link ID can only contain lowercase alphanumeric characters, underscores and dashes.' => 'El ID del enlace solo puede contener caracteres alfanumericos en minúscula, guiones medios y guiones bajos.',
            'Parent Link' => 'Enlace padre',
            'Always Visible' => 'Siempre visible',
            'No Parent' => 'Sin padre',
            'Create Menu Link' => 'Crear enlace en menú',
            'Update Menu Link' => 'Actualizar enlace en menú',
            'Menu Links' => 'Enlaces del menú',
            'Add New Menu' => 'Crear nuevo menú',
            'Add New Link' => 'Crear nuevo enlace',
            'An error occurred during saving menu!' => 'Un error ha ocurrido mientras se guardaba el menú',
            'The changes have been saved.' => 'Los cambios fueron guardados.',
            'Please, select menu to view menu links...' => 'Por favor, seleccione un menú para ver los enlaces',
            'Selected menu doesn\'t contain any link. Click "Add New Link" to create a link for this menu.' => "El Menú seleccionado no contiene ningún enlace.",
            'Permissions' => 'Permisos'
        ];
    }
}

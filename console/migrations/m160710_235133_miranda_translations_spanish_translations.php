<?php

use common\db\TranslatedMessagesMigration;

class m160710_235133_miranda_translations_spanish_translations extends TranslatedMessagesMigration
{
    public function getLanguage()
    {
        return 'es-ES';
    }

    public function getCategory()
    {
        return 'miranda/translation';
    }

    public function getTranslations()
    {
        return [
            'Add New Source Message' => 'Crear nueva fuente',
            'Category' => 'Categoría',
            'Create Message Source' => 'Crear nueva fuente',
            'Create New Category' => 'Crear nueva categoría',
            'Immutable' => 'Inmutable',
            'Message Translation' => 'Traducción',
            'New Category Name' => 'Nombre de nueva categoría',
            'Please, select message group and language to view translations...' => 'Por favor, seleccione un grupo de mensajes e idioma para ver las traducciones',
            'Source Message' => 'Fuente',
            'Update Message Source' => 'Actualizar fuente',
            '{n, plural, =1{1 message} other{# messages}}' => '{n, plural, =1{1 mensaje} other{# mensajes}}',
        ];
    }
}

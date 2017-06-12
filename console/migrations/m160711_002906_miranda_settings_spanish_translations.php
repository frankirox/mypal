<?php

use common\db\TranslatedMessagesMigration;

class m160711_002906_miranda_settings_spanish_translations extends TranslatedMessagesMigration
{
    public function getLanguage()
    {
        return 'es-ES';
    }

    public function getCategory()
    {
        return 'miranda/settings';
    }

    public function getTranslations()
    {
        return [
            'General Settings' => 'Ajustes generales',
            'Reading Settings' => 'Ajustes de lectura',
            'Contact Settings' => 'Ajustes de contacto',
            'Social Settings'  => 'Ajustes sociales',
            'Site Title' => 'Título del sitio',
            'Site Description' => 'Descripción del sitio',
            'Admin Email' => 'E-mail del administrador',
            'Default Timezone' => 'Zona horaria por defecto',
            'Default Date Format' => 'Formato de fecha por defecto',
            'Default Time Format' => 'Formato de hora por defecto',
            'Default Country' => 'País por defecto',
            'Default Language' => 'Idioma por defecto',
            'Default Page Size' => 'Tamaño de la página por defecto',
        ];
    }
}

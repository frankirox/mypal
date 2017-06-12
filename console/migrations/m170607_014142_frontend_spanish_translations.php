<?php

use yii\db\Migration;

class m170607_014142_frontend_spanish_translations extends \common\db\TranslatedMessagesMigration
{
    public function getLanguage()
    {
        return 'es-ES';
    }

    public function getCategory()
    {
        return 'miranda/frontend';
    }

    public function getTranslations()
    {
        return [
            'Verification Code' => 'Código de verificación',
            'Homepage' => 'Página principal',
            'About' => 'Nosotros',
            'Contact' => 'Contáctanos',
            'Article Listing' => 'Listado de artículos',
            'Blog' => 'Publicaciones',
            'Site Map' => 'Mapa del sitio',
        ];
    }
}

<?php

use yii\db\Migration;

class m170607_014129_frontend_source_translations extends \common\db\SourceMessagesMigration
{

    public function getCategory()
    {
        return 'miranda/frontend';
    }

    public function getMessages()
    {
        return [
            'Verification Code' => 1,
            'Homepage' => 1,
            'About' => 1,
            'Contact' => 1,
            'Article Listing' => 1,
            'Blog' => 1,
            'Site Map' => 1,
        ];
    }
}

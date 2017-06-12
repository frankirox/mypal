<?php

use common\db\SourceMessagesMigration;

class m151121_235015_i18n_miranda_settings_source extends SourceMessagesMigration
{

    public function getCategory()
    {
        return 'miranda/settings';
    }

    public function getMessages()
    {
        return [
            'General Settings' => 1,
            'Reading Settings' => 1,
            'Contact Settings' => 1,
            'Social Settings' => 1,
            'Site Title' => 1,
            'Site Description' => 1,
            'Admin Email' => 1,
            'Default Timezone' => 1,
            'Default Date Format' => 1,
            'Default Time Format' => 1,
            'Default Country' => 1,
            'Default Language' => 1,
            'Default Page Size' => 1,

        ];
    }
}
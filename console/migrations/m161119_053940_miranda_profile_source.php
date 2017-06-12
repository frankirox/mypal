<?php

use common\db\SourceMessagesMigration;

class m161119_053940_miranda_profile_source extends SourceMessagesMigration
{
    public function getCategory()
    {
        return 'miranda/profile';
    }

    public function getMessages()
    {
        return [
            'User' => 1,
            'Document ID' => 1,
            'Merchant ID' => 1,
            'Title' => 1,
            'Full Name' => 1,
            'First Name' => 1,
            'Last Name' => 1,
            'Birthday' => 1,
            'Gender' => 1,
            'Phone 1' => 1,
            'Phone 2' => 1,
            'Phone 3' => 1,
            'Skype' => 1,
            'Notes' => 1,
            'Timezone' => 1,
            'Language' => 1,
            'Country' => 1,
            'Created At' => 1,
            'Updated At' => 1,
            'Created By' => 1,
            'Updated By' => 1,
            'Male' => 1,
            'Female' => 1,
            'Mr.' => 1,
            'Miss.' => 1,
            'Ms.' => 1,
            'Mrs.' => 1,
        ];
    }
}

<?php

use common\db\TranslatedMessagesMigration;

class m161119_053957_miranda_profile_spanish_translations extends TranslatedMessagesMigration
{
    public function getLanguage()
    {
        return 'es-ES';
    }

    public function getCategory()
    {
        return 'miranda/profile';
    }

    public function getTranslations()
    {
        return [
            'User' => 'Usuario',
            'Document ID' => 'Documento de identidad',
            'Merchant ID' => 'Documento mercantil',
            'Title' => 'Título',
            'Full Name' => 'Nombre completo',
            'First Name' => 'Nombres',
            'Last Name' => 'Apellidos',
            'Birthday' => 'Cumpleaños',
            'Gender' => 'Genero',
            'Phone 1' => 'Teléfono 1',
            'Phone 2' => 'Teléfono 2',
            'Phone 3' => 'Teléfono 3',
            'Skype' => 'Skype',
            'Notes' => 'Notas',
            'Timezone' => 'Zona horaria',
            'Language' => 'Idioma',
            'Country' => 'País',
            'Created At' => 'Creado',
            'Updated At' => 'Actualizado',
            'Created By' => 'Creado por',
            'Updated By' => 'Actualizado por',
            'Male' => 'Hombre',
            'Female' => 'Mujer',
            'Mr.' => 'Sr.',
            'Miss.' => 'Srta.',
            'Ms.' => 'Sra.',
            'Mrs.' => 'Señora',
        ];
    }
}

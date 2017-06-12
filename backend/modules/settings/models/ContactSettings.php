<?php

namespace backend\modules\settings\models;

use Yii;
use yii\helpers\ArrayHelper;
use backend\modules\settings\models\BaseSettingsModel;

/**
 * @author Franchesco Fonseca <fonseca.franchesco@gmail.com>
 */
class ContactSettings extends BaseSettingsModel
{
    const GROUP = 'contact';

    public $address;
    public $phone;
    public $whatsapp;
    public $skype;
    public $email;
    public $google_maps_url;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
            [
                [['address','phone','whatsapp','skype','google_maps_url'], 'string'],
                ['email','email'],
            ]);
    }

    public function attributeLabels()
    {
        return [
            'address' => 'Dirección',
            'phone' => 'Teléfono',
            'email' => 'Dirección Email',
            'google_maps_url' => 'Google Maps URL',
            'whatsapp' => 'Whatsapp',
            'skype' => 'Skype',
        ];
    }

}
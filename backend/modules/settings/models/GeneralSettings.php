<?php

namespace backend\modules\settings\models;

use common\behaviors\MultilingualSettingsBehavior;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * @author Franchesco Fonseca <fonseca.franchesco@gmail.com>
 */
class GeneralSettings extends BaseSettingsModel
{
    const GROUP = 'general';

    public $title;
    public $description;
    public $email;
    public $timezone;
    public $dateformat;
    public $timeformat;
    public $language;
    public $country;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
            [
                [['title', 'timezone', 'dateformat', 'timeformat', 'country', 'language',], 'required'],
                [['email'], 'email'],
                [['description'], 'safe'],
                ['title', 'default', 'value' => Yii::$app->name],
                ['timezone', 'default', 'value' => Yii::$app->params['defaultTimezone']],
                ['dateformat', 'default', 'value' => Yii::$app->params['defaultDateFormat']],
                ['timeformat', 'default', 'value' => Yii::$app->params['defaultTimeFormat']],
                ['country', 'default', 'value' => Yii::$app->params['defaultCountry']],
                ['language', 'default', 'value' => Yii::$app->params['defaultLanguage']],
            ]);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'multilingualSettings' => [
                'class' => MultilingualSettingsBehavior::className(),
                'attributes' => [
                    'title',
                    'description'
                ]
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('miranda/settings', 'Site Title'),
            'description' => Yii::t('miranda/settings', 'Site Description'),
            'email' => Yii::t('miranda/settings', 'Admin Email'),
            'timezone' => Yii::t('miranda/settings', 'Default Timezone'),
            'dateformat' => Yii::t('miranda/settings', 'Default Date Format'),
            'timeformat' => Yii::t('miranda/settings', 'Default Time Format'),
            'country' => Yii::t('miranda/settings', 'Default Country'),
            'language' => Yii::t('miranda/settings', 'Default Language'),
        ];
    }

}
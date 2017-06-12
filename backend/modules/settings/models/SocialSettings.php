<?php

namespace backend\modules\settings\models;

use Yii;
use yii\helpers\ArrayHelper;
use backend\modules\settings\models\BaseSettingsModel;

/**
 * @author Franchesco Fonseca <fonseca.franchesco@gmail.com>
 */
class SocialSettings extends BaseSettingsModel
{
    const GROUP = 'social';

    public $facebook_url;
    public $twitter_url;
    public $linkedin_url;
    public $youtube_url;
    public $instagram_url;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
            [
                [['facebook_url', 'twitter_url', 'linkedin_url', 'youtube_url', 'instagram_url'], 'string'],
                ['facebook_url', 'default', 'value' => '#'],
                ['twitter_url', 'default', 'value' => '#'],
                ['linkedin_url', 'default', 'value' => '#'],
                ['youtube_url', 'default', 'value' => '#'],
                ['instagram_url', 'default', 'value' => '#'],
            ]);
    }

    public function attributeLabels()
    {
        return [
            'facebook_url' => 'Facebook',
            'twitter_url' => 'Twitter',
            'linkedin_url' => 'LinkedIn',
            'youtube_url' => 'Youtube',
            'instagram_url' => 'Instagram',
        ];
    }

}
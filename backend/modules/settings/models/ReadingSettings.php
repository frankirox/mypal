<?php

namespace backend\modules\settings\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * @author Franchesco Fonseca <fonseca.franchesco@gmail.com>
 */
class ReadingSettings extends BaseSettingsModel
{
    const GROUP = 'reading';

    public $page_size;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
            [
                [['page_size'], 'required'],
                [['page_size'], 'integer'],
                ['page_size', 'default', 'value' => 20],
            ]);
    }

    public function attributeLabels()
    {
        return [
            'page_size' => Yii::t('miranda/settings', 'Default Page Size'),
        ];
    }

}
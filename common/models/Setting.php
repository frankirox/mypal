<?php

namespace common\models;   //common\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property int $id
 * @property string $key
 * @property string $group
 * @property string $language
 * @property string $value
 * @property string $description
 *
 * @author Franchesco Fonseca <fonseca.franchesco@gmail.com>
 */
class Setting extends \common\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['value', 'language'], 'string'],
            [['key', 'group'], 'string', 'max' => 64],
        ];
    }

    public function behaviors()
    {
        return [
            \common\behaviors\FrontendCacheFlush::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'key' => Yii::t('miranda', 'Key'),
            'group' => Yii::t('miranda', 'Group'),
            'value' => Yii::t('miranda', 'Value'),
            'language' => Yii::t('miranda', 'Language'),
        ];
    }

    /**
     * Get setting by group and key
     *
     * @param type $group
     * @param type $key
     * @return type
     */
    public static function getSetting($group, $key, $language = null)
    {
        return self::findOne(['group' => $group, 'key' => $key, 'language' => $language]);
    }

}

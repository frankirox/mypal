<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_setting".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $key
 * @property string $value
 *
 * @author Franchesco Fonseca <fonseca.franchesco@gmail.com>
 */
class UserSetting extends \common\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_setting}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'key', 'value'], 'required'],
            [['user_id'], 'integer'],
            [['value'], 'string'],
            [['key'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'key' => 'Key',
            'value' => 'Value',
        ];
    }

    public function get($key, $default = null)
    {
        if ($setting = self::findOne(['user_id' => Yii::$app->user->id, 'key' => $key])) {
            return $setting->value;
        }

        return $default;
    }

    public function set($key, $value)
    {
        try {
            if ($setting = self::findOne(['user_id' => Yii::$app->user->id, 'key' => $key])) {
                $setting->value = $value;
                return ($setting->save()) ? true : false;
            }
        } catch (Exception $ex) {
            print_r($ex);
            die;
        }

        return false;
    }

}

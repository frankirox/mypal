<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "auth_item_group".
 *
 * @property string $code
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 */
class AuthItemGroup extends \common\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Yii::$app->miranda->auth_item_group_table;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            ['code', 'unique'],
            [['code'], 'string', 'max' => 64],
            [['code', 'name'], 'trim'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('miranda', 'Name'),
            'code' => Yii::t('miranda', 'Code'),
            'created_at' => Yii::t('miranda', 'Created'),
            'updated_at' => Yii::t('miranda', 'Updated'),
        ];
    }

}

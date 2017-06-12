<?php

namespace common\models;

use common\models\query\MultilingualQuery;
use common\behaviors\MultilingualBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use common\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use common\models\interfaces\OwnerAccess;

/**
 * This is the model class for table "menu_link".
 *
 * @property string $id
 * @property string $menu_id
 * @property string $link
 * @property string $label
 * @property string $target
 * @property string $parent_id
 * @property integer $alwaysVisible
 * @property string $permissions
 * @property string $image
 * @property integer $order
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Menu $menu
 */
class MenuLink extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_link}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \common\behaviors\FrontendCacheFlush::className(),
            BlameableBehavior::className(),
            TimestampBehavior::className(),
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'slugAttribute' => 'id',
                'attribute' => 'label',
            ],
            'multilingual' => [
                'class' => MultilingualBehavior::className(),
                'langForeignKey' => 'link_id',
                'tableName' => "{{%menu_lang}}",
                'attributes' => [
                    'label'
                ]
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'label'], 'required'],
            ['id', 'unique'],
            [['order', 'alwaysVisible', 'created_by', 'updated_by', 'created_at', 'updated_at',], 'integer'],
            [['id', 'menu_id', 'parent_id'], 'string', 'max' => 64],
            [['link', 'label'], 'string', 'max' => 255],
            [['target', 'permissions'], 'string', 'max' => 255], //agregado nuevo
            [['image'], 'string', 'max' => 128],
            [
                ['id'],
                'match',
                'pattern' => '/^[a-z0-9_-]+$/',
                'message' => Yii::t('miranda',
                    'Link ID can only contain lowercase alphanumeric characters, underscores and dashes.')
            ],
            ['order', 'default', 'value' => 999],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('miranda', 'ID'),
            'menu_id' => Yii::t('miranda', 'Menu'),
            'link' => Yii::t('miranda', 'Link'),
            'label' => Yii::t('miranda', 'Label'),
            'target' => Yii::t('miranda', 'Target'), // agregado nuevo
            'parent_id' => Yii::t('miranda', 'Parent Link'),
            'alwaysVisible' => Yii::t('miranda', 'Always Visible'),
            'permissions' => Yii::t('miranda', 'Permissions'),
            'image' => Yii::t('miranda', 'Icon'),
            'order' => Yii::t('miranda', 'Order'),
            'created_by' => Yii::t('miranda', 'Created By'),
            'updated_by' => Yii::t('miranda', 'Updated By'),
            'created_at' => Yii::t('miranda', 'Created'),
            'updated_at' => Yii::t('miranda', 'Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id'])->joinWith('translations');
    }

    /**
     * Get list of link siblings
     * @return array
     */
    public function getSiblings()
    {
        $siblings = MenuLink::find()->joinWith('translations')
            ->andFilterWhere(['like', 'menu_id', $this->menu_id])
            ->andFilterWhere(['!=', 'menu_link.id', $this->id])
            ->all();

        $list = ArrayHelper::map(
            $siblings, 'id', function ($array, $default) {
            return $array->label . ' [' . $array->id . ']';
        });

        return ArrayHelper::merge([null => Yii::t('miranda', 'No Parent')], $list);
    }

    /**
     * @inheritdoc
     * @return MultilingualQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

}

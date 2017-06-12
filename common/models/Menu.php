<?php

namespace common\models;

use common\models\query\MultilingualQuery;
use common\behaviors\MultilingualBehavior;
use common\helpers\FA;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use common\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use common\models\interfaces\OwnerAccess;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "menu".
 *
 * @property string $id
 * @property string $title
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property MenuLink[] $menuLinks
 */
class Menu extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
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
                'attribute' => 'title',
            ],
            'multilingual' => [
                'class' => MultilingualBehavior::className(),
                'langForeignKey' => 'menu_id',
                'tableName' => "{{%menu_lang}}",
                'attributes' => [
                    'title'
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
            [['title'], 'required'],
            ['id', 'unique'],
            ['id', 'filter', 'filter' => function ($value) {
                // normalize phone input here
                return mb_strtolower($value);
            }],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['id'], 'string', 'max' => 64],
            [['title'], 'string', 'max' => 255],
            [['id'], 'match', 'pattern' => '/^[a-z0-9_-]+$/', 'message' => Yii::t('miranda', 'Menu ID can only contain lowercase alphanumeric characters, underscores and dashes.')],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('miranda', 'ID'),
            'title' => Yii::t('miranda', 'Title'),
            'created_by' => Yii::t('miranda', 'Created By'),
            'updated_by' => Yii::t('miranda', 'Updated By'),
            'created_at' => Yii::t('miranda', 'Created'),
            'updated_at' => Yii::t('miranda', 'Updated'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getLinks()
    {
        return $this->hasMany(MenuLink::className(), ['menu_id' => 'id'])->joinWith('translations');
    }

    /**
     * get list of menus
     * @return array
     */
    public static function getMenus()
    {
        return ArrayHelper::map(self::find()->joinWith('translations')->all(), 'id', 'title');
    }

    /**
     * get list of menus
     * @return array
     */
    public static function getMenuName($menu_id)
    {
        $menu = self::findOne($menu_id);

        if($menu instanceof self){

            return $menu->title;
        }

        return  null;
    }


    /**
     * get list of menus
     * @return array
     */
    public static function getMenuItems($menu_id)
    {
        $links = self::findOne($menu_id)
                ->getLinks()
                ->orderBy(['parent_id' => 'ASC', 'order' => 'ASC'])
                ->all();

        return self::generateNavigationItems($links);
    }

    private static function generateNavigationItems($links)
    {
        $items = [];
        $linksByParent = [];

        foreach ($links as $link) {
            $linksByParent[$link->parent_id][] = $link;
        }

        foreach ($linksByParent[''] as $link) {
            $items[] = self::generateItem($link, $linksByParent);
        }

        return $items;
    }

    private static function generateItem($link, $menuLinks)
    {
        $item = [];
        //$icon = (!empty($link->image)) ? FA::icon($link->image) . ' ' : '';

        $subItems = self::generateSubItems($link->id, $menuLinks);

        $item['label'] =  $link->label;
        $item['icon'] = $link->image;

        if(Yii::$app->user->isGuest){
            $item['visible'] = false;
        }else{
            $item['visible'] = true;
        }


        if (!empty($link->permissions)){

            $explodedPermissions = explode(',',$link->permissions);

            $permissionCompliance = true;

            if(is_array($explodedPermissions)){

                foreach($explodedPermissions as $explodedPermission){

                    if(!User::hasPermission(trim($explodedPermission))){

                        $permissionCompliance = false;
                    }
                }
            }

            $item['visible'] = $permissionCompliance;
        }

        if (isset($link->alwaysVisible) && $link->alwaysVisible) {
            $item['visible'] = true;
        }

        if ($link->link) {
            $url = parse_url($link->link);
            $item['url'] = (isset($url['scheme'])) ? $link->link : [$link->link];
        }else{

            $item['url'] = 'javascript:void(0);';
        }

        if (is_array($subItems)) {
            $item['items'] = $subItems;
        }

        return $item;
    }

    private static function generateSubItems($parent_id, $menuLinks)
    {
        if (isset($menuLinks[$parent_id])) {
            $items = [];

            foreach ($menuLinks[$parent_id] as $link) {
                $items[] = self::generateItem($link, $menuLinks);
            }

            return $items;
        }

        return NULL;
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

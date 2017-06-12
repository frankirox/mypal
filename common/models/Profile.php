<?php
namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "tbl_profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $document_id
 * @property string $merchant_id
 * @property string $title
 * @property string $gender
 * @property string $birthday
 * @property string $first_name
 * @property string $last_name
 * @property string $phone_1
 * @property string $phone_2
 * @property string $phone_3
 * @property string $skype
 * @property string $notes
 * @property string $country
 * @property string $language
 * @property string $timezone
 * @property string $avatar
 * @property string $update_time
 * @property string $create_time
 *
 * @property User $user
 */
class Profile extends ActiveRecord
{

    const TITLE_MR = 'Mr.';
    const TITLE_MISS = 'Miss.';
    const TITLE_MRS = 'Mrs.';
    const TITLE_MS = 'Ms.';
    const TITLE_MX = 'Mx'; // innovation used since 1970s, used as a gender-neutral honorific or those who do not identify as male or female.

    const GENDER_MALE = 'M';
    const GENDER_FEMALE = 'F';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'country', 'timezone', 'language'], 'required'],
            [
                [
                    'first_name',
                    'last_name',
                    'phone_1',
                    'phone_2',
                    'phone_3',
                    'skype',
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    'phone_1',
                    'phone_2',
                    'phone_3'
                ],
                'string',
                'max' => '60'
            ],
            [['title', 'gender'], 'default', 'value' => ''],
            [['title'], 'string', 'max' => 6],
            [['gender'], 'string', 'max' => 1],
            [['country'], 'string', 'max' => 3],
            [['language'], 'string', 'max' => 6],
            [['timezone'], 'string', 'max' => 64],
            [['notes'], 'string'],
            [['birthday'], 'date', 'format' => 'yyyy-MM-dd'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['document_id', 'merchant_id','avatar'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('miranda/profile', 'ID'),
            'user_id' => Yii::t('miranda/profile', 'User'),
            'document_id' => Yii::t('miranda/profile', 'Document ID'),
            'merchant_id' => Yii::t('miranda/profile', 'Merchant ID'),
            'title' => Yii::t('miranda/profile', 'Title'),
            'full_name' => Yii::t('miranda/profile', 'Full Name'),
            'first_name' => Yii::t('miranda/profile', 'First Name'),
            'last_name' => Yii::t('miranda/profile', 'Last Name'),
            'birthday' => Yii::t('miranda/profile', 'Birthday'),
            'gender' => Yii::t('miranda/profile', 'Gender'),
            'phone_1' => Yii::t('miranda/profile', 'Phone 1'),
            'phone_2' => Yii::t('miranda/profile', 'Phone 2'),
            'phone_3' => Yii::t('miranda/profile', 'Phone 3'),
            'skype' => Yii::t('miranda/profile', 'Skype'),
            'notes' => Yii::t('miranda/profile', 'Notes'),
            'timezone' => Yii::t('miranda/profile', 'Timezone'),
            'language' => Yii::t('miranda/profile', 'Language'),
            'country' => Yii::t('miranda/profile', 'Country'),
            'created_at' => Yii::t('miranda/profile', 'Created At'),
            'updated_at' => Yii::t('miranda/profile', 'Updated At'),
            'created_by' => Yii::t('miranda/profile', 'Created By'),
            'updated_by' => Yii::t('miranda/profile', 'Updated By'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }


    public function getFullName()
    {

        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return array
     */
    public static function getGenderList()
    {
        return [
            self::GENDER_MALE => Yii::t('miranda/profile', 'Male'),
            self::GENDER_FEMALE => Yii::t('miranda/profile', 'Female'),
        ];
    }

    /**
     * @return array
     */
    public static function getGenderOptionsList()
    {
        return [
            [self::GENDER_MALE, Yii::t('miranda/profile', 'Male'), 'default'],
            [self::GENDER_FEMALE,Yii::t('miranda/profile', 'Female'), 'default']
        ];
    }

    /**
     * @return array
     */
    public static function getTitleList()
    {
        return [
            self::TITLE_MR => Yii::t('miranda', 'Mr.'),
            self::TITLE_MISS => Yii::t('miranda', 'Miss.'),
            self::TITLE_MRS => Yii::t('miranda', 'Mrs.'),
            self::TITLE_MS => Yii::t('miranda', 'Ms.'),
            self::TITLE_MX => Yii::t('miranda', 'Mx'),
        ];
    }

    /**
     * @return array
     */
    public static function getTitleOptionsList()
    {
        return [
            [self::TITLE_MR, Yii::t('miranda', 'Mr.'), 'default'],
            [self::TITLE_MISS, Yii::t('miranda', 'Miss.'), 'default'],
            [self::TITLE_MRS, Yii::t('miranda', 'Mrs.'), 'default'],
            [self::TITLE_MS, Yii::t('miranda', 'Ms.'), 'default'],
            [self::TITLE_MX, Yii::t('miranda', 'Mx'), 'default'],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     *
     * @param string $size
     * @return boolean|string
     */
    public function getAvatar($size = 'small')
    {
        if (!empty($this->avatar)) {
            $avatars = json_decode($this->avatar);

            if (isset($avatars->$size)) {

                return $avatars->$size;
            }
        }

        return null;
    }

    /**
     *
     * @param string $size
     * @return boolean|string
     */
    public function getAvatarUrl($size = 'small')
    {
        if (!empty($this->avatar)) {
            $avatars = json_decode($this->avatar);
            
            if (isset($avatars->$size)) {

                $explodeContent = explode(DIRECTORY_SEPARATOR, $avatars->$size);

                if(is_array($explodeContent)){

                    $reverseArray = array_reverse($explodeContent);
                    $filename = $reverseArray[0];
                    $url = Yii::$app->urlManager->hostInfo . '/storage/avatars/'. $filename;

                    return $url;
                }

            }
        }

        return null;
    }

    /**
     *
     * @param array $avatars
     */
    public function setAvatars($avatars)
    {
        $this->avatar = json_encode($avatars);
        return $this->save();
    }

    /**
     *
     */
    public function removeAvatar()
    {
        $this->avatar = '';
        return $this->save();
    }


}

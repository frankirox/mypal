<?php
namespace backend\modules\user\forms;

use common\models\User;
use common\models\Profile;
use Composer\Package\Loader\ValidatingArrayLoader;
use yii\base\Model;
use Yii;
use yii\helpers\VarDumper;

/**
 * Class UpdateAccountForm
 * @package backend\modules\user\forms
 *
 * @property integer $document_id
 * @property integer $merchant_id
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
 * @property string $profile_picture
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property string $email
 * @property string $username
 * @property string $currentPassword
 * @property string $newPassword
 * @property string $newPasswordConfirmation
 *
 */

class UpdateAccountForm extends Model
{

    //profile tbl;
    public $document_id;//
    public $merchant_id;//
    public $title; //
    public $gender; //
    public $birthday;//
    public $first_name;//
    public $last_name;//
    public $phone_1;//
    public $phone_2;//
    public $phone_3;//
    public $skype;//
    public $notes;//
    public $country;//
    public $language;//
    public $timezone;//
    public $updated_at;
    public $updated_by;

    //User tbl
    public $email;//
    public $username;//
    public $currentPassword;
    public $newPassword;//
    public $newPasswordConfirmation;//

    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            [
                [
                    'first_name',
                    'last_name',
                    'phone_1',
                    'country',
                    'language',
                    'timezone',
                    'email',
                    'username',
                    'currentPassword',
                    'birthday',
                ],
                'required'
            ],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            [['title'], 'string', 'max' => 6],
            [['gender'], 'string', 'max' => 1],
            [['country'], 'string', 'max' => 3],
            [['language'], 'string', 'max' => 6],
            [['timezone'], 'string', 'max' => 64],
            [['notes'], 'string'],
            [
                [
                    'phone_1',
                    'phone_2',
                    'phone_3'
                ],
                'string',
                'max' => '60'
            ],
            [
                [
                    'first_name',
                    'last_name',
                    'username',
                    'phone_1',
                    'phone_2',
                    'phone_3',
                    'skype',
                    'email',
                    'username',
                    'currentPassword',
                    'newPassword',
                    'newPasswordConfirmation',
                ],
                'string',
                'max' => 255
            ],
            ['newPassword', 'string', 'min' => 6],
            ['newPasswordConfirmation', 'compare', 'compareAttribute' => 'newPassword'],
            [
                ['username'],
                'match',
                'pattern' => '/^[A-Za-z0-9_]+$/u',
                'message' => Yii::t('miranda/profile', 'The username can contain only letters, numbers, and "_"')
            ],
            [['username'], 'uniqueUsername'],
            [['currentPassword'], 'currentPasswordVerify'],
        ];

    }

    /**
     * Attribute Labels
     */
    public function attributeLabels()
    {
        return [
            'document_id'               => Yii::t('miranda/profile', 'Document ID'),
            'merchant_id'               => Yii::t('miranda/profile', 'Merchant ID'),
            'title'                     => Yii::t('miranda/profile', 'Title'),
            'gender'                    => Yii::t('miranda/profile', 'Gender'),
            'birthday'                  => Yii::t('miranda/profile', 'Birthday'),
            'first_name'                => Yii::t('miranda/profile', 'Firstname'),
            'last_name'                 => Yii::t('miranda/profile', 'Lastname'),
            'phone_1'                   => Yii::t('miranda/profile', 'Phone #1'),
            'phone_2'                   => Yii::t('miranda/profile', 'Phone #2'),
            'phone_3'                   => Yii::t('miranda/profile', 'Phone #3'),
            'skype'                     => Yii::t('miranda/profile', 'Skype'),
            'notes'                     => Yii::t('miranda/profile', 'Notes'),
            'country'                   => Yii::t('miranda/profile', 'Country'),
            'language'                  => Yii::t('miranda/profile', 'Language'),
            'timezone'                  => Yii::t('miranda/profile', 'Timezone'),
            'updated_at'                => Yii::t('miranda/profile', 'Updated At'),
            'updated_by'                => Yii::t('miranda/profile', 'Updated By'),
            'email'                     => Yii::t('miranda/profile', 'Email'),
            'username'                  => Yii::t('miranda/profile', 'Username'),
            'currentPassword'           => Yii::t('miranda/profile', 'Current Password'),
            'newPassword'               => Yii::t('miranda/profile', 'New Password'),
            'newPasswordConfimation'    => Yii::t('miranda/profile', 'New Password Confirmation'),

        ];
    }

    public function uniqueUsername($attribute, $params)
    {

        if (!empty($this->username)){

            $existingUsername = User::find()->where(['username' => $this->username]);

            if ($this->username == $existingUsername){

                $this->addError($attribute, Yii::t('miranda/profile', 'This username is in use.'));
            }
        }

    }

    public function currentPasswordVerify($attribute, $params)
    {

        $user = Yii::$app->user->identity;

        if (!empty($this->currentPassword)){

            if (!password_verify($this->currentPassword, $user->password_hash)){

                $this->addError($attribute, Yii::t('miranda/profile', 'Password must match with the current password.'));
            }
        }

    }

    public function save()
    {

        if ($this->validate()){

            $profile = Yii::$app->user->identity->profile;

            $birthday = strtotime($this->birthday);

            $profile->document_id = $this->document_id;
            $profile->merchant_id = $this->merchant_id;
            $profile->title = $this->title;
            $profile->gender = $this->gender;
            $profile->birthday = date('Y-m-d', $birthday);
            $profile->first_name = $this->first_name;
            $profile->last_name = $this->last_name;
            $profile->phone_1 = $this->phone_1;
            $profile->phone_2 = $this->phone_2;
            $profile->phone_3 = $this->phone_3;
            $profile->skype = $this->skype;
            $profile->notes = $this->notes;
            $profile->country = $this->country;
            $profile->language = $this->language;
            $profile->timezone = $this->timezone;

            $user = Yii::$app->user->identity;

            $user->email = $this->email;
            $user->username = $this->username;

            if (!empty($this->newPassword)){

                $user->password = $this->newPassword;
                //$user->newPassword = $this->newPassword;
                //$user->newPasswordConfirmation = $this->newPasswordConfirmation;
            }

            if ($user->validate() and $profile->validate()){

                if ($user->save() and $profile->save()){

                    return true;
                }
            }

            return false;

        }

        return false;

    }


}



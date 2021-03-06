<?php

namespace backend\modules\user\forms;

use common\models\Profile;
use common\models\User;
use Yii;
use yii\base\Model;

/**
 * This is the model class for table "tbl_user".
 *
 * @property boolean $superadmin
 * @property string $username
 * @property string $password
 * @property string $repeat_password
 * @property string $email
 * @property boolean $email_confirmed
 * @property integer $status
 * @property string $bind_to_ip
 *
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
 *
 */
class UpdateUserForm extends Model
{

    //user attributes
    public $superadmin; //
    public $username; //
    public $email; //
    public $email_confirmed; //
    public $status; //
    public $bind_to_ip; //

    //profile attributes
    public $user_id;
    public $document_id; //
    public $merchant_id; //
    public $title; //
    public $gender; //
    public $birthday; //
    public $first_name;//
    public $last_name;//
    public $phone_1; //
    public $phone_2;//
    public $phone_3;//
    public $skype; //
    public $notes;
    public $country; //
    public $language; //
    public $timezone; //
    public $avatar;


    public function init()
    {
        if (empty($this->country)) {

            $this->country = Yii::$app->params['defaultCountry'];
        }

        if (empty($this->language)) {

            $this->language = Yii::$app->params['defaultLanguage'];
        }

        parent::init(); // TODO: Change the autogenerated stub
    }

    /**
     * @inheritdoc
     */
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'username',
                    'email',
                    'status',
                ],
                'required'
            ],
            [
                [
                    'superadmin',
                    'email_confirmed',
                ],
                'boolean',
            ],
            [
                [
                    'superadmin',
                    'email_confirmed',
                ],
                'default',
                'value' => false,
            ],
            [
                [
                    'username',
                    'email',
                    'bind_to_ip',
                ],
                'string',
                'max' => 255,
            ],
            ['email', 'email'],
            ['status', 'integer'],
            //profile
            [
                [
                    'title',
                    'gender',
                    'first_name',
                    'last_name',
                    'country',
                    'language',
                    'timezone',
                ],
                'required',
            ],
            ['user_id', 'integer'],
            [
                [
                    'document_id',
                    'merchant_id',
                    'title',
                    'first_name',
                    'last_name',
                    'phone_1',
                    'phone_2',
                    'phone_3',
                    'skype',
                    'country',
                ],
                'string',
                'max' => 255,
            ],
            ['timezone', 'string', 'max' => 64],
            ['language', 'string', 'max' => 6],
            ['notes', 'string'],
            [['birthday'], 'date', 'format' => 'yyyy-MM-dd'],
            ['gender', 'string', 'max' => 1],
            [['username', 'email', 'bind_to_ip'], 'trim'],
            //custom Validation Methods
            ['username', 'validateUsernameUnique'],
            [
                'username',
                'match',
                'pattern' => Yii::$app->miranda->usernameRegexp,
                'message' => Yii::t('miranda',
                    'The username should contain only Latin letters, numbers and the following characters: "-" and "_".')
            ],
            [
                'username',
                'match',
                'not' => true,
                'pattern' => Yii::$app->miranda->usernameBlackRegexp,
                'message' => Yii::t('miranda', 'Username contains not allowed characters or words.')
            ],
            ['email', 'validateEmailUnique'],
            ['bind_to_ip', 'validateBindToIp'],
        ];
    }

    /**
     * Check that there is no such confirmed E-mail in the system
     */
    public function validateEmailUnique()
    {
        if (!empty($this->email)) {

            $emailToBeUpdated = User::findOne(['email' => $this->email]);

            if ($emailToBeUpdated->email != $this->email) {

                if ($emailToBeUpdated instanceof User) {
                    $this->addError('email', Yii::t('miranda', 'This e-mail already exists'));
                }
            }

        }
    }

    /**
     * Check that there is no such confirmed E-mail in the system
     */
    public function validateUsernameUnique()
    {
        if (!empty($this->username)) {

            $usernameTobeUpdated = User::findOne(['username' => $this->username]);

            if ($usernameTobeUpdated->username != $this->username) {

                if ($usernameTobeUpdated instanceof User) {
                    $this->addError('username', Yii::t('miranda', 'This username already exists'));
                }
            }

        }
    }

    /**
     * Validate bind_to_ip attr to be in correct format
     */
    public function validateBindToIp()
    {
        if (!empty($this->bind_to_ip)) {
            $ips = explode(',', $this->bind_to_ip);

            foreach ($ips as $ip) {
                if (!filter_var(trim($ip), FILTER_VALIDATE_IP)) {
                    $this->addError('bindToIp', Yii::t('miranda', "Wrong format. Enter valid IPs separated by comma"));
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'superadmin' => Yii::t('miranda', 'Super Administrator'),
            'bind_to_ip' => Yii::t('miranda', 'Bind to IP'),
            'status' => Yii::t('miranda', 'Status'),
            'email_confirmed' => Yii::t('miranda', 'E-mail confirmed'),
            'email' => Yii::t('miranda', 'E-mail'),
            'user_id' => Yii::t('miranda', 'User'),
            'document_id' => Yii::t('miranda', 'Document ID'),
            'merchant_id' => Yii::t('miranda', 'Merchant ID'),
            'first_name' => Yii::t('miranda', 'First Name'),
            'last_name' => Yii::t('miranda', 'Last Name'),
            'phone' => Yii::t('miranda', 'Phone'),
            'timezone' => Yii::t('miranda', 'Timezone'),
            'language' => Yii::t('miranda', 'Language'),
            'country' => Yii::t('miranda', 'Country'),
        ];
    }


    public function save()
    {

        if ($this->validate()) {

            $user = User::findOne($this->user_id);
            $user->setAttributes([
                'superadmin' => $this->superadmin,
                'username' => $this->username,
                'email' => $this->email,
                'email_confirmed' => $this->email_confirmed,
                'status' => $this->status,
                'bind_to_ip' => $this->bind_to_ip,
            ]);

            $profile = Profile::findOne(['user_id' => $this->user_id]);
            $profile->setAttributes([
                'user_id' => $user->id,
                'document_id' => $this->document_id,
                'merchant_id' => $this->merchant_id,
                'title' => $this->title,
                'gender' => $this->gender,
                'birthday' => $this->birthday,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'phone_1' => $this->phone_1,
                'phone_2' => $this->phone_2,
                'phone_3' => $this->phone_3,
                'skype' => $this->skype,
                'notes' => $this->notes,
                'country' => $this->country,
                'language' => $this->language,
                'timezone' => $this->timezone,
                'avatar' => $this->avatar,
            ]);

            if ($user->validate() && $profile->validate()) {

                $user->save();
                $profile->save();
                return true;
            }

        }

        return false;

    }


    /**
     * Get created date
     *
     * @return string
     */
    public function getCreatedDate()
    {
        return Yii::$app->formatter->asDate(time());
    }

    /**
     * Get created date
     *
     * @return string
     */
    public function getUpdatedDate()
    {
        return Yii::$app->formatter->asDate(time());
    }

    /**
     * Get created time
     *
     * @return string
     */
    public function getCreatedTime()
    {
        return Yii::$app->formatter->asTime(time());
    }

    /**
     * Get created time
     *
     * @return string
     */
    public function getUpdatedTime()
    {
        return Yii::$app->formatter->asTime(time());
    }

    /**
     * Get created datetime
     *
     * @return string
     */
    public function getCreatedDatetime()
    {
        return "{$this->createdDate} {$this->createdTime}";
    }

    /**
     * Get created datetime
     *
     * @return string
     */
    public function getUpdatedDatetime()
    {
        return "{$this->updatedDate} {$this->updatedTime}";
    }
}
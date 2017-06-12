<?php

namespace backend\modules\auth\models\forms;

use common\models\User;
use common\models\Profile;
use Yii;
use yii\base\Model;
use yii\helpers\Html;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $repeat_password;
    public $captcha;

    //profile attributes
    public $first_name;
    public $last_name;
    public $country;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            ['captcha', 'captcha', 'captchaAction' => '/auth/default/captcha'],
            [['username', 'email', 'password', 'repeat_password', 'captcha'], 'required'],
            [['username', 'email', 'password', 'repeat_password'], 'trim'],
            [['email'], 'email'],
            ['username', 'unique',
                'targetClass' => 'common\models\User',
                'targetAttribute' => 'username',
            ],
            ['email', 'unique',
                'targetClass' => 'common\models\User',
                'targetAttribute' => 'email',
            ],
            ['username', 'purgeXSS'],
            ['username', 'string', 'max' => 50],
            ['username', 'match', 'pattern' => Yii::$app->miranda->usernameRegexp],
            ['username', 'match', 'not' => true, 'pattern' => Yii::$app->miranda->usernameBlackRegexp],
            ['password', 'string', 'max' => 255],
            ['repeat_password', 'compare', 'compareAttribute' => 'password'],
            [['first_name', 'last_name', 'country'], 'required'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
        ];

        return $rules;
    }

    /**
     * Remove possible XSS stuff
     *
     * @param $attribute
     */
    public function purgeXSS($attribute)
    {
        $this->$attribute = Html::encode($this->$attribute);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('miranda', 'Username'),
            'email' => Yii::t('miranda/auth', 'E-mail'),
            'password' => Yii::t('miranda/auth', 'Password'),
            'repeat_password' => Yii::t('miranda/auth', 'Repeat password'),
            'captcha' => Yii::t('miranda/auth', 'Captcha'),
        ];
    }

    /**
     * @param bool $performValidation
     *
     * @return bool|User
     */
    public function signup($performValidation = true)
    {
        if ($performValidation AND !$this->validate()) {
            return false;
        }

        $user = new User();
        $user->password = $this->password;
        $user->username = $this->username;
        $user->email = $this->email;

        if (Yii::$app->miranda->emailConfirmationRequired) {

            $user->status = User::STATUS_INACTIVE;
            $user->generateConfirmationToken();
            // $user->save(false);

            if (!$this->sendConfirmationEmail($user)) {
                $this->addError('username', Yii::t('miranda/auth', 'Could not send confirmation email'));
            }

        }

        if($user->save()){

            $profile = new Profile([
                'user_id' => $user->id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'country'   => $this->country,
            ]);

            if(!$profile->save()){

                $user->delete();

            }else{

                return $user;
            }

        } else {

            $this->addError('username', Yii::t('miranda/auth', 'Login has been taken'));

        }

        return false;
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    protected function sendConfirmationEmail($user)
    {
        return Yii::$app->mailer->compose(Yii::$app->miranda->emailTemplates['signup-confirmation'], ['user' => $user])
            ->setFrom(Yii::$app->miranda->emailSender)
            ->setTo($user->email)
            ->setSubject(Yii::t('miranda/auth', 'E-mail confirmation for') . ' ' . Yii::$app->name)
            ->send();
    }

    /**
     * Check received confirmation token and if user found - activate it, set username, roles and log him in
     *
     * @param string $token
     *
     * @return bool|User
     */
    public function checkConfirmationToken($token)
    {
        $user = User::findInactiveByConfirmationToken($token);

        if ($user) {
            
            $user->status = User::STATUS_ACTIVE;
            $user->email_confirmed = 1;
            $user->removeConfirmationToken();
            $user->save(false);
            $user->assignRoles(Yii::$app->miranda->defaultRoles);
            Yii::$app->user->login($user);

            return $user;
        }

        return false;
    }
}
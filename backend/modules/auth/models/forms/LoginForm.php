<?php

namespace backend\modules\auth\models\forms;

use common\helpers\MirandaHelper;
use common\models\User;
use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = false;
    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
            ['username', 'validateIP'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('miranda/auth', 'Username'),
            'password' => Yii::t('miranda/auth', 'Password'),
            'rememberMe' => Yii::t('miranda/auth', 'Remember me'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        if (!Yii::$app->miranda->checkAttempts()) {
            $this->addError('password', Yii::t('miranda/auth', 'Too many attempts'));
            return false;
        }

        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', Yii::t('miranda/auth', 'Incorrect username or password'));
            }
        }
    }

    /**
     * Check if user is binded to IP and compare it with his actual IP
     */
    public function validateIP()
    {
        $user = $this->getUser();

        if ($user AND $user->bind_to_ip) {
            $ips = explode(',', $user->bind_to_ip);
            $ips = array_map('trim', $ips);

            if (!in_array(MirandaHelper::getRealIp(), $ips)) {
                $this->addError('password', Yii::t('miranda/auth', "You could not login from this IP"));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(),
                $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
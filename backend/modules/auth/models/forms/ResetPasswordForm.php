<?php

namespace backend\modules\auth\models\forms;

use common\models\User;
use Yii;
use yii\base\Model;

class ResetPasswordForm extends Model
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $captcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['captcha', 'captcha', 'captchaAction' => '/auth/default/captcha'],
            [['email', 'captcha'], 'required'],
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'validateEmailConfirmedAndUserActive'],
        ];
    }

    /**
     * @return bool
     */
    public function validateEmailConfirmedAndUserActive()
    {
        if (!Yii::$app->miranda->checkAttempts()) {
            $this->addError('email', Yii::t('miranda/auth', 'Too many attempts'));
            return false;
        }

        $user = User::findOne([
            'email' => $this->email,
            'email_confirmed' => 1,
            'status' => User::STATUS_ACTIVE,
        ]);

        if ($user) {
            $this->user = $user;
        } else {
            $this->addError('email', Yii::t('miranda/auth', 'E-mail is invalid'));
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
            'captcha' => Yii::t('miranda/auth', 'Captcha'),
        ];
    }

    /**
     * @param bool $performValidation
     *
     * @return bool
     */
    public function sendEmail($performValidation = true)
    {
        if ($performValidation AND !$this->validate()) {
            return false;
        }

        $this->user->generateConfirmationToken();
        $this->user->save(false);

        return Yii::$app->mailer->compose(Yii::$app->miranda->emailTemplates['password-reset'],
            ['user' => $this->user])
            ->setFrom(Yii::$app->miranda->emailSender)
            ->setTo($this->email)
            ->setSubject(Yii::t('miranda/auth', 'Password reset for') . ' ' . Yii::$app->name)
            ->send();
    }
}
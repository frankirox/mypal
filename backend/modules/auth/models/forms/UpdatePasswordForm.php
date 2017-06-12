<?php

namespace backend\modules\auth\models\forms;

use common\models\User;
use Yii;
use yii\base\Model;

class UpdatePasswordForm extends Model
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var string
     */
    public $current_password;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $repeat_password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'repeat_password'], 'required'],
            [['password', 'repeat_password', 'current_password'], 'string', 'max' => 255],
            [['password', 'repeat_password', 'current_password'], 'string', 'min' => 6],
            [['password', 'repeat_password', 'current_password'], 'trim'],
            ['repeat_password', 'compare', 'compareAttribute' => 'password'],
            ['current_password', 'required', 'except' => 'restoreViaEmail'],
            ['current_password', 'validateCurrentPassword', 'except' => 'restoreViaEmail'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'current_password' => Yii::t('miranda/auth', 'Current password'),
            'password' => Yii::t('miranda/auth', 'Password'),
            'repeat_password' => Yii::t('miranda/auth', 'Repeat password'),
        ];
    }

    /**
     * Validates current password
     */
    public function validateCurrentPassword()
    {
        if (!Yii::$app->miranda->checkAttempts()) {
            $this->addError('current_password', Yii::t('miranda/auth', 'Too many attempts'));
            return false;
        }

        if (!Yii::$app->security->validatePassword($this->current_password, $this->user->password_hash)) {
            $this->addError('current_password', Yii::t('miranda/auth', "Wrong password"));
        }
    }

    /**
     * @param bool $performValidation
     *
     * @return bool
     */
    public function updatePassword($performValidation = true)
    {
        if ($performValidation AND !$this->validate()) {
            return false;
        }

        $this->user->password = $this->password;
        $this->user->removeConfirmationToken();
        return $this->user->save();
    }
}

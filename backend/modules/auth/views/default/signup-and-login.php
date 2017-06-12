<?php

use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var frontend\modules\auth\models\forms\RegistrationForm $model
 */
$this->title = Yii::t('miranda/frontend', 'New Account') .'/'.  Yii::t('miranda/frontend', 'Sign in');

$this->params['breadcrumbs'][] = $this->title;

?>

        <div class="col-md-6">

            <div class="box">

                <h1><?= Yii::t('miranda/frontend', 'New account'); ?></h1>

                <p class="lead"><?= Yii::t('miranda/frontend', 'Not our registered customer yet?'); ?></p>

                <p>
                    <?= Yii::t('miranda/frontend', 'By registering an account you will get fantastic discounts and much more and the whole
                    process will not take more than a minute of your time!'); ?>
                </p>

                <p class="text-muted">
                    <?= Yii::t('miranda/frontend', 'If you have any questions, please feel free to'); ?>
                    <?= Html::a(Yii::t('miranda/fronten', 'contact us'), ['/site/contact']); ?>
                    <?= Yii::t('miranda/frontend', 'our customer service center is working for you 24/7.'); ?>
                </p>

                <hr>

                <?php $form = ActiveForm::begin([
                    'id' => 'signup',
                    'validateOnBlur' => false,
                    'action' => Url::to(['/auth/signup']),
                    'options' => ['autocomplete' => 'off'],
                ]); ?>

                <?= $form->field($signUpForm, 'username')->textInput(['maxlength' => 50]) ?>

                <?= $form->field($signUpForm, 'first_name')->textInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>

                <?= $form->field($signUpForm, 'last_name')->textInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>

                <?=
                \common\widgets\CountrySelect\CountrySelect::widget(
                    [
                        'model' => $signUpForm,
                        'attribute' => 'country',
                        'form' => $form,
                        'options' => ['class' => 'form-group select-field'],
                    ]
                );
                ?>

                <?= $form->field($signUpForm, 'email')->textInput(['maxlength' => 255]) ?>

                <?= $form->field($signUpForm, 'password')->passwordInput(['maxlength' => 255]) ?>

                <?= $form->field($signUpForm, 'repeat_password')->passwordInput(['maxlength' => 255]) ?>

                <?= $form->field($signUpForm, 'captcha')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-sm-3">{image}</div><div class="col-sm-3">{input}</div></div>',
                    'captchaAction' => [\yii\helpers\Url::to(['/auth/captcha'])]
                ]) ?>

                <?= Html::submitButton(Yii::t('miranda/auth', 'Signup'), ['class' => 'btn btn-lg btn-primary btn-block']) ?>

                <?php ActiveForm::end() ?>

            </div>
        </div>

        <div class="col-md-6">

            <div class="box">
                <h1><?= Yii::t('miranda/frontend', 'Login'); ?></h1>

                <p class="lead"><?= Yii::t('miranda/frontend', 'Already our customer?'); ?></p>

                <p class="text-muted"><?= Yii::t('miranda/frontend', 'Use your username or email and password to login.'); ?></p>

                <hr>

                <?php $form = ActiveForm::begin([
                    'id' => 'login-form-modal',
                    'action' => Url::to(['/auth/login']),
                    'options' => ['autocomplete' => 'off'],
                    'validateOnBlur' => false,
                ]);
                ?>

                    <?= $form->field($logInForm, 'username')->textInput(['class' => 'form-control', 'placeholder' => $logInForm->getAttributeLabel('username'), 'autocomplete' => 'off']); ?>

                    <?= $form->field($logInForm, 'password')->passwordInput(['class' => 'form-control traking-input', 'placeholder' => $logInForm->getAttributeLabel('password'), 'autocomplete' => 'off']) ?>

                    <p class="text-center">
                        <?= Html::submitButton(Yii::t('miranda/auth', '<i class="fa fa-sign-in"></i> Log in'), ['class' => 'btn btn-primary btn-lg btn-block', 'id' => 'login']) ?>
                    </p>

                <?php ActiveForm::end() ?>

                <div class="row registration-block">
                    <div class="text-center">
                        <?= Html::a(Yii::t('miranda/auth', "Can't access to your account?"), ['default/reset-password']) ?>
                    </div>
                </div>

            </div>

        </div>

<?php
$css = <<<CSS

#signup-wrapper {
	position: relative;
	top: 30%;
}
#signup-wrapper .registration-block {
	margin-top: 15px;
}
CSS;

$this->registerCss($css);
?>



















<?php

use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\modules\auth\models\forms\PasswordRecoveryForm $model
 */
$this->title = Yii::t('miranda/auth', 'Password recovery');

?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert-alert-warning text-center">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>


    <div id="login-wrapper" style="padding-left: 5%; padding-right: 5%;">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center"><?= $this->title ?></h3>
                    </div>
                    <div class="panel-body">

                        <?php $form = ActiveForm::begin([
                            'id' => 'reset-form',
                            'options' => ['autocomplete' => 'off'],
                            'validateOnBlur' => false,
                        ]); ?>

                        <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

                        <?= $form->field($model, 'captcha')->widget(Captcha::className(), [
                            'template' => '<div class="row"><div class="col-sm-3">{image}</div><div class="col-sm-9">{input}</div></div>',
                            'captchaAction' => ['/auth/captcha']
                        ]) ?>

                        <?= Html::submitButton(Yii::t('miranda/auth', 'Reset Password'), ['class' => 'btn btn-lg btn-success btn-block']) ?>

                        <br>

                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <?= Html::a(Yii::t("miranda/auth", "Do you remember your password? Sign In"), ['default/login','language' => Yii::$app->miranda->getDisplayLanguageShortcode(Yii::$app->language)]) ?>
                            </div>
                        </div>

                        <?php ActiveForm::end() ?>

                    </div>

                </div>
            </div>
        </div>
    </div>


                        <?php /*<div class="col-md-6 col-md-offset-3">

                            <div class="box">

                                <h3 class="text-center"><?= Yii::t('miranda/frontend', 'Reset Password'); ?></h3>

                                <?php $form = ActiveForm::begin([
                                    'id' => 'reset-form',
                                    'options' => ['autocomplete' => 'off'],
                                    'validateOnBlur' => false,
                                ]); ?>

                                <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

                                <?= $form->field($model, 'captcha')->widget(Captcha::className(), [
                                    'template' => '<div class="row"><div class="col-sm-3">{image}</div><div class="col-sm-3">{input}</div></div>',
                                    'captchaAction' => ['/auth/captcha']
                                ]) ?>

                                <?= Html::submitButton(Yii::t('miranda/auth', 'Reset'), ['class' => 'btn btn-lg btn-primary btn-block']) ?>

                                <?php ActiveForm::end() ?>

                            </div>

                        </div>*/ ?>


    <?php /*<div id="update-wrapper">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= $this->title ?></h3>
                    </div>
                    <div class="panel-body">

                        <?php $form = ActiveForm::begin([
                            'id' => 'reset-form',
                            'options' => ['autocomplete' => 'off'],
                            'validateOnBlur' => false,
                        ]); ?>

                        <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

                        <?= $form->field($model, 'captcha')->widget(Captcha::className(), [
                            'template' => '<div class="row"><div class="col-sm-3">{image}</div><div class="col-sm-3">{input}</div></div>',
                            'captchaAction' => ['/auth/captcha']
                        ]) ?>

                        <?= Html::submitButton(Yii::t('miranda/auth', 'Reset'), ['class' => 'btn btn-lg btn-primary btn-block']) ?>

                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div> */?>

<?php
$css = <<<CSS
#update-wrapper {
	position: relative;
	top: 30%;
}
CSS;

$this->registerCss($css);
?>
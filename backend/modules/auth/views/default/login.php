<?php

/**
 * @var $this yii\web\View
 * @var $model frontend\modules\auth\models\forms\LoginForm
 */
use frontend\modules\auth\widgets\AuthChoice;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('miranda/auth', 'Authorization');

?>


    <div id="login-wrapper" style="padding-left: 5%; padding-right: 5%;">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center"><?= $this->title ?></h3>
                    </div>
                    <div class="panel-body">

                        <?php
                        $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'options' => ['autocomplete' => 'off'],
                            'validateOnBlur' => false,
                            'fieldConfig' => [
                                'template' => "{input}\n{error}",
                            ],
                        ])
                        ?>

                        <?= $form->field($model, 'username')->textInput(['placeholder' => $model->getAttributeLabel('username'), 'autocomplete' => 'off']) ?>

                        <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password'), 'autocomplete' => 'off']) ?>

                        <?= $form->field($model, 'rememberMe')->checkbox(['value' => true]) ?>

                        <?= Html::submitButton(Yii::t('miranda/auth', 'Login'), ['class' => 'btn btn-lg btn-success btn-block']) ?>

                        <br>

                        <div class="row">
                            <div class="col-sm-6 text-left">
                                <?=  \common\widgets\LanguageSelector::widget(['display' => 'label', 'view' => 'pills']); ?>
                            </div>
                            <div class="col-sm-6 text-right">
                                <?= Html::a(Yii::t('miranda/auth', "Forgot password?"), ['default/reset-password', 'language' =>  Yii::$app->miranda->getDisplayLanguageShortcode(Yii::$app->language)]) ?>
                            </div>
                        </div>

                        <?php ActiveForm::end() ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php
$css = <<<CSS

#login-wrapper {
	position: relative;
	top: 30%;
}
#login-wrapper .registration-block {
	margin-top: 15px;
}
CSS;

$this->registerCss($css);
?>
<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\modules\auth\models\forms\UpdateCredentialsForm $model
 */
$this->title = Yii::t('miranda/auth', 'Update Access Credentials');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success text-center">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

    <div id="update-wrapper">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">

                        <h2><?= $this->title ?></h2>
                        <div class="panel_toolbox">
                            <?= Html::a(Yii::t('miranda/auth', 'Update Profile'), ['/auth/default/profile'], ['class' => 'btn btn-primary btn-sm']) ?>
                        </div>
                        <div class="clearfix"></div>

                    </div>
                    <div class="x_content">

                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <?php $form = ActiveForm::begin([
                                'id' => 'update-form',
                                'options' => ['autocomplete' => 'off'],
                                'validateOnBlur' => false,
                            ]) ?>

                            <?= $form->field($model, 'username')->textInput(['maxlength' => 50]) ?>

                            <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

                            <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>

                            <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255]) ?>

                            <?= $form->field($model, 'current_password')->passwordInput(['maxlength' => 255]) ?>

                            <hr>

                            <?= Html::submitButton(Yii::t('miranda', 'Update'), ['class' => 'btn btn-lg btn-primary btn-block']) ?>

                            <?php ActiveForm::end() ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php
$css = <<<CSS
#update-wrapper {
	position: relative;
	top: 30%;
}
CSS;

$this->registerCss($css);
?>
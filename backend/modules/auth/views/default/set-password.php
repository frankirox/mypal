<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\modules\auth\models\forms\UpdatePasswordForm $model
 */
$this->title = Yii::t('miranda/auth', 'Set Password');
?>

    <div id="update-wrapper">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= $this->title ?></h3>
                    </div>
                    <div class="panel-body">

                        <?php $form = ActiveForm::begin([
                            'id' => 'update-form',
                            'options' => ['autocomplete' => 'off'],
                            'validateOnBlur' => false,
                        ]) ?>

                        <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>

                        <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255]) ?>

                        <?= Html::submitButton(Yii::t('miranda', 'Update'), ['class' => 'btn btn-lg btn-primary btn-block']) ?>

                        <?php ActiveForm::end() ?>
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
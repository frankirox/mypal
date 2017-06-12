<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\modules\auth\models\forms\UpdatePasswordForm $model
 */
$this->title = Yii::t('miranda/frontend', 'Update Password');

$this->params['breadcrumbs'][] = ['label' => Yii::t('miranda/frontend', 'My Account'), 'url' => ['/auth/profile']];

$this->params['breadcrumbs'][] = $this->title;

?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success text-center">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>



            <!-- *** LEFT COLUMN ***
         _________________________________________________________ -->

            <div class="col-md-9 clearfix" id="customer-account">

                <div class="box clearfix">

                    <h3><?= Yii::t('miranda/frontend', 'Change password'); ?></h3>

                    <?php $form = ActiveForm::begin([
                        'id' => 'update-form',
                        'options' => ['autocomplete' => 'off'],
                        'validateOnBlur' => false,
                    ]) ?>

                        <div class="row">

                            <div class="col-sm-6">
                                <?php if ($model->scenario != 'restoreViaEmail'): ?>
                                    <?= $form->field($model, 'current_password')->passwordInput(['maxlength' => 255]) ?>
                                <?php endif; ?>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm-6">
                                <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>
                            </div>

                            <div class="col-sm-6">
                                <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255]) ?>
                            </div>

                        </div>

                        <div class="text-center">

                            <?= Html::submitButton(Yii::t('miranda', 'Update'), ['class' => 'btn btn-lg btn-primary btn-block']) ?>

                        </div>

                    <?php ActiveForm::end() ?>

                </div>

            </div>

            <div class="col-md-3">
                <?= $this->render('//layouts/menu/_customer-section-menu'); ?>
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
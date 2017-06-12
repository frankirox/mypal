<?php

use backend\modules\auth\assets\AvatarAsset;
use backend\modules\auth\assets\AvatarUploaderAsset;
use backend\modules\auth\widgets\AuthChoice;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\MirandaHelper;

/**
 * @var yii\web\View $this
 * @var frontend\modules\auth\models\forms\SetEmailForm $model
 */
$this->title = Yii::t('miranda/auth', 'User Profile');
$this->params['breadcrumbs'][] = $this->title;

AvatarUploaderAsset::register($this);
AvatarAsset::register($this);

?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success text-center">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<div class="profile-index">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">

                    <h2><?= $this->title ?></h2>
                    <div class="panel_toolbox">
                        <?= Html::a(Yii::t('miranda/auth', 'Update Access Credentials'),
                            ['/auth/default/update-credentials'], ['class' => 'btn btn-primary btn-sm']) ?>
                    </div>
                    <div class="clearfix"></div>

                </div>
                <div class="x_content">

                    <div class="col-md-2 col-sm-2 col-xs-12 profile_left">

                        <div class="image-uploader">
                            <?php
                            ActiveForm::begin([
                                'method' => 'post',
                                'action' => Url::to(['/auth/default/upload-avatar']),
                                'options' => ['enctype' => 'multipart/form-data', 'autocomplete' => 'off'],
                            ])
                            ?>

                            <?php $avatar = ($userAvatar = Yii::$app->user->identity->profile->getAvatar('large')) ? $userAvatar : AvatarAsset::getDefaultAvatar('large') ?>
                            <div class="image-preview" data-default-avatar="<?= $avatar ?>">
                                <img src="<?= $avatar ?>"/>
                            </div>
                            <div class="image-actions">
                    <span class="btn btn-primary btn-file"
                          title="<?= Yii::t('miranda/auth', 'Change profile picture') ?>" data-toggle="tooltip"
                          data-placement="left">
                        <i class="fa fa-folder-open fa-lg"></i>
                        <?= Html::fileInput('image', null, ['class' => 'image-input']) ?>
                    </span>

                                <?=
                                Html::submitButton('<i class="fa fa-save fa-lg"></i>', [
                                    'class' => 'btn btn-primary image-submit',
                                    'title' => Yii::t('miranda/auth', 'Save profile picture'),
                                    'data-toggle' => 'tooltip',
                                    'data-placement' => 'top',
                                ])
                                ?>

                                <span class="btn btn-primary image-remove"
                                      data-action="<?= Url::to(['/auth/default/remove-avatar']) ?>"
                                      title="<?= Yii::t('miranda/auth', 'Remove profile picture') ?>"
                                      data-toggle="tooltip"
                                      data-placement="right">
                        <i class="fa fa-remove fa-lg"></i>
                    </span>
                            </div>
                            <div class="upload-status"></div>

                            <?php ActiveForm::end() ?>
                        </div>

                    </div>
                    <div class="col-md-10 col-sm-10 col-xs-12">

                        <?php
                        $form = ActiveForm::begin([
                            'id' => 'user',
                            'validateOnBlur' => false,
                        ])
                        ?>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'document_id')->textInput(['maxlength' => 255]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'merchant_id')->textInput(['maxlength' => 255]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <?= $form->field($model,
                                    'title')->dropDownList(\common\models\Profile::getTitleList()) ?>
                            </div>
                            <div class="col-md-5">
                                <?= $form->field($model, 'first_name')->textInput(['maxlength' => 255]) ?>
                            </div>
                            <div class="col-md-5">
                                <?= $form->field($model, 'last_name')->textInput(['maxlength' => 255]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model,
                                    'gender')->dropDownList(\common\models\Profile::getGenderList()) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'birthday')->widget(\yii\jui\DatePicker::classname(), [
                                    'dateFormat' => 'yyyy-MM-dd',
                                    'options' => ['class' => 'form-control']
                                ]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($model, 'skype')->textInput(['maxlength' => 64]) ?>
                            </div>
                            <div class="col-md-12">
                                <?= $form->field($model, 'phone_1')->textInput(['maxlength' => 24]) ?>
                            </div>
                            <div class="col-md-12">
                                <?= $form->field($model, 'phone_2')->textInput(['maxlength' => 24]) ?>
                            </div>
                            <div class="col-md-12">
                                <?= $form->field($model, 'phone_3')->textInput(['maxlength' => 24]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($model, 'notes')->textarea(['maxlength' => 255]) ?>
                            </div>
                        </div>

                        <hr>

                        <?= Html::submitButton(Yii::t('miranda/auth', 'Save Profile'),
                            ['class' => 'btn btn-primary btn-block']) ?>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<?php
$confRemovingAuthMessage = Yii::t('miranda/auth', 'Are you sure you want to unlink this authorization?');
$confRemovingAvatarMessage = Yii::t('miranda/auth', 'Are you sure you want to delete your profile picture?');
$js = <<<JS
confRemovingAuthMessage = "{$confRemovingAuthMessage}";
confRemovingAvatarMessage = "{$confRemovingAvatarMessage}";
JS;

$this->registerJs($js, yii\web\View::POS_READY);
?>

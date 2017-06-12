<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use common\models\Profile;
use kartik\widgets\DatePicker;
use kartik\form\ActiveField;
use yii\helpers\Url;
use common\widgets\CountrySelect\CountrySelect;
use common\widgets\LanguageSelect\LanguageSelect;

$this->title = Yii::t('miranda/profile', 'My Account');
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $user->profile->fullName . "({$user->username})";

?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

            <div class="x_title">
                <h2><?= $this->title ?></h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                <?php if ($flash = Yii::$app->session->getFlash("Account-success")): ?>

                    <div class="alert alert-success">
                        <p><?= $flash ?></p>
                    </div>

                <?php elseif ($flash = Yii::$app->session->getFlash("Resend-success")): ?>

                    <div class="alert alert-success">
                        <p><?= $flash ?></p>
                    </div>

                <?php elseif ($flash = Yii::$app->session->getFlash("Cancel-success")): ?>

                    <div class="alert alert-success">
                        <p <?= $flash; ?>
                    </div>

                <?php endif; ?>

                <?php $form = ActiveForm::begin([
                    'id' => 'account-form',
                    'options' => ['class' => 'form-horizontal'],
                    //'validationUrl' => Url::to(['validate']),
                    'action' => Url::to(['account']),
                    'fieldConfig' => [
                        //'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
                        //'labelOptions' => ['class' => 'col-lg-12 control-label'],
                    ],
                    'enableClientValidation'    => false,
                    'validateOnSubmit'          => false,
                    'enableAjaxValidation'      => false,
                ]); ?>

                <div class="row nomargin">

                    <div class="container bs-callout bs-callout-info">

                        <h4><?= Yii::t('miranda/profile', 'Personal Information') ?></h4><hr>

                        <div class="col-md-4 text-center">

                            <?= \common\widgets\ProfilePicture\ProfilePicture::widget([
                                'model' => $profile,
                                'attribute' => 'profilePictureUrl',
                                'imgReplacingClass' => 'profile-picture',
                                'webcamActionUrl' => \yii\helpers\Url::to(['profile-picture-webcam']),
                                'uploadActionUrl' => \yii\helpers\Url::to(['profile-picture-upload']),
                                'saveActionUrl' => \yii\helpers\Url::to(['profile-picture-save', 'id' => $profile->id])
                            ]); ?>

                        </div>

                        <div class="col-md-8 nopadding">

                            <div class="row form-group nopadding">

                                <div class="col-md-2">
                                    <?= $form->field($model, 'title')->widget(\kartik\select2\Select2::classname(), [
                                        'data' => Profile::getTitleList(),
                                        'options' => ['placeholder' => ''],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]); ?>
                                </div>

                                <div class="col-md-5">
                                    <?= $form->field($model, 'first_name',[
                                        'template' => "{label} {input} {error} <br>",
                                        'options' => [
                                            'tag'=>'span'
                                        ]
                                    ])->textInput([
                                        'maxlength' => 255,
                                        'class'     => 'form-control',
                                    ]) ?>
                                </div>

                                <div class="col-md-5">
                                    <?= $form->field($model, 'last_name',[
                                        'options' => [
                                            'tag'=>'span'
                                        ]
                                    ])->textInput([
                                        'maxlength' => 255,
                                        'class'     => 'form-control',
                                    ]) ?>
                                </div>

                            </div>

                            <div class="row form-group nopadding">

                                <div class="col-md-2">
                                    <?= $form->field($model, 'gender')->widget(\kartik\select2\Select2::classname(), [
                                        'data' => Profile::getGenderList(),
                                        'options' => ['placeholder' => ''],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]); ?>
                                </div>

                                <div class="col-md-5">
                                    <?= $form->field($model, 'birthday')->widget(DatePicker::classname(), [
                                        'options' => ['placeholder' => 'Enter birth date ...'],
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            'format' => 'yyyy-mm-dd'
                                        ]
                                    ]); ?>
                                </div>

                                <div class="col-md-5">
                                    <?=
                                    CountrySelect::widget(
                                        [
                                            'model' => $model,
                                            'attribute' => 'country',
                                            'form' => $form,
                                        ]
                                    );
                                    ?>
                                </div>

                            </div>

                            <div class="row form-group nopadding">

                                <div class="col-md-6">
                                    <?=
                                    LanguageSelect::widget(
                                        [
                                            'model'     => $model,
                                            'attribute' => 'language',
                                            'form'      => $form,
                                        ]
                                    );
                                    ?>
                                </div>

                                <div class="col-md-6">
                                    <?= $form->field($model, 'timezone',[
                                        'template' => "{label} {input} {error} <br>",
                                        'options' => [
                                            'tag'=>'span'
                                        ]
                                    ])->dropDownList(['TZ1' => 'TZ1'], ['promt' => '']); ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row nomargin">

                    <div class="container bs-callout bs-callout-info">

                        <h4><?= Yii::t('miranda/profile', 'User account information') ?></h4><hr>

                        <?php if($user->email): ?>
                            <div class="col-md-6">
                                <?= $form->field($model, 'email',[
                                    'options' => [
                                        'tag'=>'span'
                                    ]
                                ])->textInput([
                                    'maxlength' => 255,
                                    'class'     => 'form-control',
                                ]) ?>
                            </div>
                        <?php endif; ?>

                        <div class="col-md-6">
                            <?= $form->field($model, 'username',[
                                'options' => [
                                    'tag'=>'span'
                                ]
                            ])->textInput([
                                'maxlength' => 255,
                                'class'     => 'form-control',
                            ]) ?>
                        </div>

                    </div>

                </div>

                <div class="row nomargin">

                    <div class="container bs-callout bs-callout-info">

                        <h4><?= Yii::t('miranda/profile', 'Change Password') ?></h4><hr>

                        <div class="col-md-6">
                            <?= $form->field($model, 'newPassword')->passwordInput() ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'newPasswordConfirmation')->passwordInput() ?>
                        </div>

                    </div>

                </div>

                <div class="row nomargin">

                    <div class="container bs-callout bs-callout-info">
                        <h4><?= Yii::t('miranda/profile', 'Commercial Information') ?></h4><hr>

                        <div class="col-md-6">
                            <?= $form->field($model, 'document_id',[
                                'template' => "{label} {input} {error} <br>",
                                'options' => [
                                    'tag'=>'span'
                                ]
                            ])->textInput([
                                'maxlength' => 255,
                                'class'     => 'form-control',
                            ]) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'merchant_id',[
                                'template' => "{label} {input} {error} <br>",
                                'options' => [
                                    'tag'=>'span'
                                ]
                            ])->textInput([
                                'maxlength' => 255,
                                'class'     => 'form-control',
                            ]) ?>
                        </div>

                    </div>
                </div>

                <div class="row nomargin">

                    <div class="container bs-callout bs-callout-info">

                        <h4><?= Yii::t('miranda/profile', 'Contact information') ?></h4><hr>

                        <div class="col-md-6">
                            <?= $form->field($model, 'phone_1')->widget(\yii\widgets\MaskedInput::classname(), [
                                'mask' => Yii::$app->params['phoneMask'],
                            ]); ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'phone_2')->widget(\yii\widgets\MaskedInput::classname(), [
                                'mask' => Yii::$app->params['phoneMask'],
                            ]); ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'phone_3')->widget(\yii\widgets\MaskedInput::classname(), [
                                'mask' => Yii::$app->params['phoneMask'],
                            ]); ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'skype',[
                                'template' => "{label} {input} {error} <br>",
                                'options' => [
                                    'tag'=>'span'
                                ]
                            ])->textInput([
                                'maxlength' => 255,
                                'class'     => 'form-control',
                            ]) ?>
                        </div>

                    </div>
                </div>

                <div class="row nomargin">

                    <div class="container bs-callout bs-callout-info">

                        <h4><?= Yii::t('miranda/profile', 'Other information') ?></h4><hr>

                        <div class="col-md-12">
                            <?= $form->field($model, 'notes', [
                                'hintType' => ActiveField::HINT_SPECIAL,
                                'hintSettings' => ['placement' => 'right', 'onLabelClick' => true, 'onLabelHover' => false]
                            ])->textArea([
                                'id' => 'address-input',
                                'placeholder' => Yii::t('miranda/profile', 'Enter notes...'),
                                'rows' => 4
                            ])->hint(Yii::t('miranda/profile', 'Notes is used to leave comments to a user o either to remid yourself something important that must be done on the account')); ?>
                        </div>

                    </div>
                </div>

                <div class="row nomargin">
                    <div class="container bs-callout bs-callout-danger">

                        <h4><?= Yii::t('miranda/profile', 'Account Verification') ?></h4><hr>

                        <div class="col-md-12">
                            <h4 style="color:red"><?= Yii::t('miranda', 'Note: Updating your account information need current password verification.') ?></h4>
                            <?= $form->field($model, 'currentPassword')->passwordInput() ?>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-12">
                        <?= Html::submitButton(Yii::t('miranda', 'Update'), ['class' => 'btn btn-block btn-lg btn-primary']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>

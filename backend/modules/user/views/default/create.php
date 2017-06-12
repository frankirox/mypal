<?php

use common\helpers\Html;
use common\models\User;
use common\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use common\models\Role;

/**
 * @var yii\web\View $this
 * @var common\models\User $model
 * @var common\widgets\ActiveForm $form
 */

$this->title = Yii::t('miranda/user', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('miranda/user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-create">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>

    <div class="user-form">

        <?php
        $form = ActiveForm::begin([
            'id' => 'user',
            'validateOnBlur' => true,
        ]);
        ?>

        <div class="row">
            <div class="col-md-9">

                <div class="panel panel-default">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-2">
                                <?= $form->field($model, 'title')->widget(Select2::classname(), [
                                    'data' => \common\models\Profile::getTitleList(),
                                    'size' => 'md',
                                    'options' => [
                                        'placeholder' => Yii::t('miranda', 'Select a title'),
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ]); ?>
                            </div>
                            <div class="col-md-5">
                                <?= $form->field($model, 'first_name')->textInput([
                                    'maxlength' => 255,
                                    'autocomplete' => 'off'
                                ]) ?>
                            </div>
                            <div class="col-md-5">
                                <?= $form->field($model, 'last_name')->textInput([
                                    'maxlength' => 255,
                                    'autocomplete' => 'off'
                                ]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'birthday')->widget(MaskedInput::className(), [
                                    'clientOptions' => [
                                        'alias' => 'yyyy-mm-dd',
                                        'greedy' => false,
                                    ]
                                ]); ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'gender')->widget(Select2::classname(), [
                                    'data' => \common\models\Profile::getGenderList(),
                                    'size' => 'md',
                                    'options' => [
                                        'placeholder' => Yii::t('miranda', 'Select a gender'),
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ]); ?>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'document_id')->widget(MaskedInput::className(), [
                                    'mask' => Yii::$app->params['documentIdFormat'],
                                    'clientOptions' => [
                                        //'repeat' => 3,
                                        'greedy' => false,
                                    ]
                                ]); ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'merchant_id')->widget(MaskedInput::className(), [
                                    'mask' => Yii::$app->params['merchantIdFormat'],
                                    'clientOptions' => [
                                        //'repeat' => 3,
                                        'greedy' => false,
                                    ]
                                ]); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <?= $form->field($model, 'phone_1')->widget(MaskedInput::className(), [
                                    'mask' => Yii::$app->params['phoneFormat'],
                                    'clientOptions' => [
                                        'greedy' => false,
                                    ]
                                ]); ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, 'phone_2')->widget(MaskedInput::className(), [
                                    'mask' => Yii::$app->params['phoneFormat'],
                                    'clientOptions' => [
                                        'greedy' => false,
                                    ]
                                ]); ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, 'phone_3')->widget(MaskedInput::className(), [
                                    'mask' => Yii::$app->params['phoneFormat'],
                                    'clientOptions' => [
                                        'greedy' => false,
                                    ]
                                ]); ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, 'skype')->textInput([
                                    'maxlength' => 255,
                                    'autocomplete' => 'off'
                                ]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'username')->textInput([
                                    'maxlength' => 255,
                                    'autocomplete' => 'off'
                                ]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'email')->widget(MaskedInput::className(), [
                                    'clientOptions' => [
                                        'alias' => 'email',
                                        'greedy' => false,
                                    ]
                                ]); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'password')->passwordInput([
                                    'maxlength' => 255,
                                    'autocomplete' => 'off'
                                ]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'repeat_password')->passwordInput([
                                    'maxlength' => 255,
                                    'autocomplete' => 'off'
                                ]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?php if (User::hasPermission('bindUserToIp')): ?>
                                    <?= $form->field($model, 'bind_to_ip')->widget(MaskedInput::className(), [
                                        'clientOptions' => [
                                            'alias' => 'ip',
                                            'greedy' => false,
                                        ]
                                    ])->hint(Yii::t('miranda', 'For example') . ' : 123.34.56.78, 234.123.89.78'); ?>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <?=
                                \common\widgets\LanguageSelect\LanguageSelect::widget(
                                    [
                                        'model' => $model,
                                        'attribute' => 'language',
                                        'form' => $form,
                                        'languages' => Yii::$app->params['languages'],
                                        'options' => ['class' => 'form-group select-field'],
                                    ]
                                );
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?=
                                \common\widgets\CountrySelect\CountrySelect::widget(
                                    [
                                        'model' => $model,
                                        'attribute' => 'country',
                                        'form' => $form,
                                        'options' => ['class' => 'form-group select-field'],
                                    ]
                                );
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?=
                                \common\widgets\TimezoneSelect\TimezoneSelect::widget(
                                    [
                                        'model' => $model,
                                        'attribute' => 'timezone',
                                        'form' => $form,
                                        'options' => ['class' => 'form-group select-field'],
                                        'allowEmpty' => true,
                                    ]
                                );
                                ?>
                            </div>
                        </div>

                        <?= $form->field($model, 'notes')->textarea() ?>

                    </div>
                </div>
            </div>

            <div class="col-md-3">


                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>
                            <span class="glyphicon glyphicon-th"></span> <?= Yii::t('miranda/user', 'Roles') ?>
                        </strong>
                    </div>
                    <div class="panel-body">

                        <?= $form->field($model, 'roles')->checkboxList(ArrayHelper::map(Role::getAvailableRoles(),
                            'name', 'description'),
                            [
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    $list = '<ul style="padding-left: 10px">';
                                    foreach (Role::getPermissionsByRole($value) as $permissionName => $permissionDescription) {
                                        $list .= $permissionDescription ? "<li>{$permissionDescription}</li>" : "<li>{$permissionName}</li>";
                                    }
                                    $list .= '</ul>';

                                    $helpIcon = Html::beginTag('span', [
                                        'title' => Yii::t('miranda/user', 'Permissions for "{role}" role',
                                            ['role' => $label]),
                                        'data-content' => $list,
                                        'data-html' => 'true',
                                        'role' => 'button',
                                        'style' => 'margin: 0 30px 5px 0; padding: 0 5px;',
                                        'class' => 'btn btn-sm btn-default role-help-btn',
                                    ]);
                                    $helpIcon .= '?';
                                    $helpIcon .= Html::endTag('span');

                                    $checkbox = Html::checkbox($name, $checked, ['label' => $label, 'value' => $value]);
                                    return "<div><div style='margin-left: 15px; display: inline-block;'>{$checkbox}</div><div style='display: inline-block; margin-left: 15px;'>{$helpIcon}</div></div>";

                                },
                            ]) ?>


                        <br/>

                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="record-info">

                            <div class="form-group clearfix">
                                <label class="control-label" style="float: left; padding-right: 5px;">
                                    <?= Yii::t('miranda', 'Registration IP') ?> :
                                </label>
                                <span><?= \common\helpers\MirandaHelper::getRealIp() ?></span>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label" style="float: left; padding-right: 5px;">
                                    <?= Yii::t('miranda', 'Created') ?> :
                                </label>
                                <span><?= "{$model->createdDate} {$model->createdTime}" ?></span>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label" style="float: left; padding-right: 5px;">
                                    <?= Yii::t('miranda', 'Updated') ?> :
                                </label>
                                <span><?= $model->updatedDatetime ?></span>
                            </div>

                            <?= $form->field($model, 'status')->dropDownList(User::getStatusList()) ?>

                            <?= $form->field($model, 'superadmin', [
                                'template' => '<br> {input}{label}{error}{hint}',
                                'labelOptions' => ['class' => 'cbx-label'],
                            ])->widget(\kartik\checkbox\CheckboxX::classname(),
                                [
                                    'autoLabel' => false,
                                    'pluginOptions' => ['threeState' => false]
                                ]
                            );
                            ?>

                            <?php if (User::hasPermission('editUserEmail')): ?>
                                <?= $form->field($model, 'email_confirmed', [
                                    'template' => '<br> {input}{label}{error}{hint}',
                                    'labelOptions' => ['class' => 'cbx-label'],
                                ])->widget(\kartik\checkbox\CheckboxX::classname(),
                                    [
                                        'autoLabel' => false,
                                        'pluginOptions' => ['threeState' => false]
                                    ]
                                );
                                ?>
                            <?php endif; ?>

                            <hr>

                            <div class="form-group ">
                                <?= Html::submitButton(Yii::t('miranda', 'Create'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('miranda', 'Cancel'), ['/user/default/index'],
                                    ['class' => 'btn btn-default']) ?>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
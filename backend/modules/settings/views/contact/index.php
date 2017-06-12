<?php

use common\helpers\Html;
use backend\modules\settings\assets\SettingsAsset;
use common\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Setting */
/* @var $form common\widgets\ActiveForm */

$this->title = Yii::t('miranda/settings', 'Contact Settings');
$this->params['breadcrumbs'][] = $this->title;

SettingsAsset::register($this);
?>
<div class="setting-index">

    <div class="row">
        <div class="col-lg-12"><h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3></div>
    </div>

    <div class="setting-form">
        <?php
        $form = ActiveForm::begin([
            'id' => 'setting-form',
            'validateOnBlur' => false,
            'fieldConfig' => [
                'template' => "<div class=\"settings-group\"><div class=\"settings-label\">{label}</div>\n<div class=\"settings-field\">{input}\n{hint}\n{error}</div></div>"
            ],
        ])
        ?>

        <div class="panel panel-default">
            <div class="panel-body">
                <br>

                <?= $form->field($model,
                    'address')->textInput(['maxlength' => true])->hint($model->getDescription('address')) ?>
                <?= $form->field($model,
                    'phone')->textInput(['maxlength' => true])->hint($model->getDescription('phone')) ?>
                <?= $form->field($model,
                    'skype')->textInput(['maxlength' => true])->hint($model->getDescription('skype')) ?>
                <?= $form->field($model,
                    'whatsapp')->textInput(['maxlength' => true])->hint($model->getDescription('whatsapp')) ?>
                <?= $form->field($model,
                    'email')->textInput(['maxlength' => true])->hint($model->getDescription('email')) ?>
                <?= $form->field($model,
                    'google_maps_url')->textInput(['maxlength' => true])->hint($model->getDescription('google_maps_url')) ?>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-lg-12">
                        <?= Html::submitButton(Yii::t('miranda', 'Save'), ['class' => 'btn btn-block btn-primary']) ?>
                    </div>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>



<?php

use common\helpers\Html;
use backend\modules\settings\assets\SettingsAsset;
use common\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Setting */
/* @var $form common\widgets\ActiveForm */

$this->title = Yii::t('miranda/settings', 'Social Settings');
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
                    'facebook_url')->textInput(['maxlength' => true])->hint($model->getDescription('facebook_url')) ?>
                <?= $form->field($model,
                    'twitter_url')->textInput(['maxlength' => true])->hint($model->getDescription('twitter_url')) ?>
                <?= $form->field($model,
                    'instagram_url')->textInput(['maxlength' => true])->hint($model->getDescription('linkedin_url')) ?>
                <?= $form->field($model,
                    'youtube_url')->textInput(['maxlength' => true])->hint($model->getDescription('linkedin_url')) ?>
                <?= $form->field($model,
                    'linkedin_url')->textInput(['maxlength' => true])->hint($model->getDescription('linkedin_url')) ?>


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



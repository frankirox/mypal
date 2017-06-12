<?php

use common\helpers\Html;
use backend\modules\settings\assets\SettingsAsset;
use backend\modules\settings\models\GeneralSettings;
use common\widgets\ActiveForm;
use common\widgets\LanguagePills;

/* @var $this yii\web\View */
/* @var $model backend\common\models\Setting */
/* @var $form common\widgets\ActiveForm */

$this->title = Yii::t('miranda/settings', 'General Settings');
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

                <?= LanguagePills::widget() ?>

                <br>
                <br>

                <?= $form->field($model, 'title', ['multilingual' => true])->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'description',
                    ['multilingual' => true])->textInput(['maxlength' => true])/*->hint($model->getDescription('description'))*/ ?>

                <?= $form->field($model,
                    'email')->textInput(['maxlength' => true])->hint($model->getDescription('email')) ?>

                <?=
                \common\widgets\TimezoneSelect\TimezoneSelect::widget(
                    [
                        'model' => $model,
                        'attribute' => 'timezone',
                        'form' => $form,
                        'options' => ['class' => 'form-group select-field'],
                        'hint' => $model->getDescription('timezone'),
                    ]
                );
                ?>

                <?=
                \common\widgets\DateFormatSelect\DateFormatSelect::widget(
                    [
                        'model' => $model,
                        'attribute' => 'dateformat',
                        'form' => $form,
                        'options' => ['class' => 'form-group select-field'],
                        'hint' => $model->getDescription('dateformat'),
                    ]
                );
                ?>

                <?=
                \common\widgets\TimeFormatSelect\TimeFormatSelect::widget(
                    [
                        'model' => $model,
                        'attribute' => 'timeformat',
                        'form' => $form,
                        'options' => ['class' => 'form-group select-field'],
                        'hint' => $model->getDescription('timeformat'),
                    ]
                );
                ?>

                <?=
                \common\widgets\CountrySelect\CountrySelect::widget(
                    [
                        'model' => $model,
                        'attribute' => 'country',
                        'form' => $form,
                        'options' => ['class' => 'form-group select-field'],
                        //'hint' => $model->getDescription('country'),
                    ]
                );
                ?>

                <?=
                \common\widgets\LanguageSelect\LanguageSelect::widget(
                    [
                        'model' => $model,
                        'attribute' => 'language',
                        'form' => $form,
                        'languages' => Yii::$app->params['languages'],
                        'options' => ['class' => 'form-group select-field'],
                        //'hint' => $model->getDescription('language'),
                    ]
                );
                ?>

                <br>

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



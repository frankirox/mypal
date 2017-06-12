<?php

/**
 * @var common\widgets\ActiveForm $form
 * @var common\models\Permission $model
 */

use common\helpers\Html;
use common\models\AuthItemGroup;
use yii\helpers\ArrayHelper;
use common\widgets\ActiveForm;

?>

<div class="permission-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'permission-form',
        'validateOnBlur' => false,
    ])
    ?>

    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $form->field($model, 'description')->textInput(['maxlength' => 255, 'autofocus' => $model->isNewRecord ? true : false]) ?>
                    <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="record-info">

                        <?= $form->field($model, 'group_code')
                            ->dropDownList(ArrayHelper::map(AuthItemGroup::find()->asArray()->all(), 'code', 'name'), ['prompt' => '']) ?>

                        <hr>
                        
                        <div class="form-group">
                            <?php if ($model->isNewRecord): ?>
                                <?= Html::submitButton(Yii::t('miranda', 'Create'), ['class' => 'btn btn-block btn-primary']) ?>
                                <?= Html::a(Yii::t('miranda', 'Cancel'), ['/user/permission/index'], ['class' => 'btn btn-block btn-default']) ?>
                            <?php else: ?>
                                <?= Html::submitButton(Yii::t('miranda', 'Save'), ['class' => 'btn btn-block btn-primary']) ?>
                                <?= Html::a(Yii::t('miranda', 'Delete'), ['delete', 'id' => $model->name], [
                                    'class' => 'btn btn-block btn-default',
                                    'data' => [
                                        'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

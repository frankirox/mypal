<?php

use common\helpers\Html;
use common\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\Pet */
/* @var $form common\widgets\ActiveForm */
?>

<div class="post-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'pet-form',
        'validateOnBlur' => false,
    ])
    ?>


    <div class="row">
        <div class="col-md-9">

            <div class="panel panel-default">
                <div class="panel-body">


                    <?= $form->field($model, 'breed')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'age')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'sold_at')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="record-info">
                        <?php if (!$model->isNewRecord): ?>

                            <div class="form-group clearfix">
                                <label class="control-label" style="float: left; padding-right: 5px;">
                                    <?= $model->attributeLabels()['created_by'] ?> :
                                </label>
                                <span><?= $model->createdBy->username ?></span>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label" style="float: left; padding-right: 5px;">
                                    <?= $model->attributeLabels()['created_at'] ?> :
                                </label>
                                <span><?= $model->created_at ?></span>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label" style="float: left; padding-right: 5px;">
                                    <?= $model->attributeLabels()['updated_at'] ?> :
                                </label>
                                <span><?= $model->updated_at ?></span>
                            </div>


                            <hr>

                        <?php endif; ?>

                        <div class="form-group">
                            <?php if ($model->isNewRecord): ?>
                                <?= Html::submitButton(Yii::t('miranda', 'Create'),
                                    ['class' => 'btn btn-block btn-primary']) ?>
                                <?= Html::a(Yii::t('miranda', 'Cancel'), ['/pet/default/index'],
                                    ['class' => 'btn btn-block btn-default']) ?>
                            <?php else: ?>
                                <?= Html::submitButton(Yii::t('miranda', 'Save'),
                                    ['class' => 'btn btn-block btn-primary']) ?>
                                <?= Html::a(Yii::t('miranda', 'Delete'), ['/pet/default/delete', 'id' => $model->id], [
                                    'class' => 'btn btn-block btn-default',
                                    'data' => [
                                        'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                        'method' => 'post',
                                    ],
                                ]) ?>
                                <?= Html::a(Yii::t('miranda', 'Close'), ['/pet/default/index'],
                                    ['class' => 'btn btn-block btn-default']) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

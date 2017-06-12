<?php

use common\helpers\Html;
use common\helpers\FA;
use common\models\Menu;
use common\widgets\ActiveForm;
use common\widgets\LanguagePills;

/* @var $this yii\web\View */
/* @var $model \backend\modules\menu\models\search\SearchMenuLink */
/* @var $form common\widgets\ActiveForm */
?>

    <div class="menu-link-form">

        <?php
        $form = ActiveForm::begin([
            'id' => 'menu-link-form',
            'validateOnBlur' => false,
        ])
        ?>

        <div class="row">
            <div class="col-md-9">

                <div class="panel panel-default">
                    <div class="panel-body">

                        <?php if ($model->isMultilingual()): ?>
                            <?= LanguagePills::widget() ?>
                        <?php endif; ?>

                        <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

                        <?php if ($model->isNewRecord): ?>
                            <?= $form->field($model, 'id')->textInput() ?>
                        <?php endif; ?>

                        <?php //$form->field($model, 'parent_id')->dropDownList($model->getSiblings(), ['class' => 'clearfix']) ?>

                        <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'target')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'permissions')->textInput(['maxlength' => true]) ?>

                        <?php // $form->field($model, 'order')->textInput() ?>

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
                                        <?= $model->attributeLabels()['id'] ?> :
                                    </label>
                                    <span><?= $model->id ?></span>
                                </div>
                            <?php endif; ?>

                            <?= $form->field($model, 'alwaysVisible', [
                                'template' => '{input}{label}{error}{hint}',
                                'labelOptions' => ['class' => 'cbx-label'],
                            ])->widget(
                                \kartik\checkbox\CheckboxX::classname(),
                                [
                                    'autoLabel' => false,
                                    'pluginOptions' => ['threeState' => false]
                                ]
                            );
                            ?>

                            <?php if ($model->isNewRecord): ?>
                                <?= $form->field($model, 'menu_id')->dropDownList(Menu::getMenus(),
                                    ['class' => 'clearfix form-control']) ?>
                            <?php endif; ?>

                            <?= $form->field($model, 'image')->dropDownList(FA::getIconsList(), [
                                'class' => 'clearfix form-control fa-font-family',
                                'encode' => false,
                            ]) ?>

                            <hr>

                            <div class="form-group">
                                <?php if ($model->isNewRecord): ?>
                                    <?= Html::submitButton(Yii::t('miranda', 'Create'),
                                        ['class' => 'btn btn-block btn-primary']) ?>
                                    <?= Html::a(Yii::t('miranda', 'Cancel'), ['/menu/link/index'],
                                        ['class' => 'btn btn-block btn-default']) ?>
                                <?php else: ?>
                                    <?= Html::submitButton(Yii::t('miranda', 'Save'),
                                        ['class' => 'btn btn-block btn-primary']) ?>
                                    <?= Html::a(Yii::t('miranda', 'Delete'),
                                        ['/menu/link/delete', 'id' => $model->id], [
                                            'class' => 'btn btn-block btn-default',
                                            'data' => [
                                                'confirm' => Yii::t('yii',
                                                    'Are you sure you want to delete this item?'),
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
<?php
$js = <<<JS

    $('#menulink-image-styler ul li').each(function(){
        var glyphicon = $(this).text();
        $(this).addClass('glyphicon').addClass('glyphicon-'+glyphicon).html('');
    });
    $('#menulink-image-styler ul li:first').html('No Icon');

    setTimeout(function(){
       
    },1000);
    

JS;
$this->registerJs($js);
?>
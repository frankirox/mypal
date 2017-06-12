<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

?>

<?=
$form->field($model, $attribute)->widget(Select2::classname(), [
    'data' => $languageIds,
    'options' => [
        'placeholder' => Yii::t('miranda', 'Select a language'),
        'value' => ((!empty($model->{$attribute})) ? $model->{$attribute} : Yii::$app->miranda->defaultLanguage)
    ],
    'pluginOptions' => $pluginOptions,
]);
?>
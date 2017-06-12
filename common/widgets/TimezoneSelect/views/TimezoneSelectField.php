<?php

use kartik\widgets\Select2;
?>

<?=
$form->field($model, $attribute)->widget(Select2::classname(), [
    'data' =>  $timezones,
    'options' => ['placeholder' => Yii::t('miranda','Select a timezone'),'value' => ((!empty($model->{$attribute}))? $model->{$attribute} : Yii::$app->miranda->defaultTimezone)],
    'pluginOptions' => $pluginOptions,
]);
?>
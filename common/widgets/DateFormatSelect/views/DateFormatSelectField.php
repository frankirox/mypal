<?= $form->field($model, $attribute,
    ['options' => $options])->dropDownList(($allowEmpty ? array_replace([
    '' => Yii::t('miranda', 'Default Value') . ': ' . $dateFormats[Yii::$app->miranda->defaultDateFormat]
],
    $dateFormats) : $dateFormats))->hint($hint); ?>
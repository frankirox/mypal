<?= $form->field($model, $attribute, ['options' => $options])->dropDownList(($allowEmpty ? array_replace([
    '' => Yii::t('miranda', 'Default Value') . ': ' . $timeFormats[Yii::$app->miranda->defaultTimeFormat]
], $timeFormats) : $timeFormats))->hint($hint); ?>
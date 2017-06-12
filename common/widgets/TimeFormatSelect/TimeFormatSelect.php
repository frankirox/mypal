<?php

namespace common\widgets\TimeFormatSelect;

use Yii;

class TimeFormatSelect extends \yii\bootstrap\Widget
{

    public $model;
    public $form;
    public $options = ['class' => 'form-group select-field'];
    public $attribute;
    public $hint;
    public $allowEmpty = false;

    public function init()
    {
        parent::init();
    }

    protected function getTimeFormats()
    {
        $timestamp = strtotime('2015-01-01 09:45:59');
        return [
            'h:mm a' => Yii::$app->formatter->asTime($timestamp, "h:mm a"),
            'hh:mm a' => Yii::$app->formatter->asTime($timestamp, "hh:mm a"),
            'HH:mm' => Yii::$app->formatter->asTime($timestamp, "HH:mm"),
            'H:mm' => Yii::$app->formatter->asTime($timestamp, "H:mm"),
        ];
    }


    public function run()
    {
        return $this->render(
            'TimeFormatSelectField',
            [
                'form' => $this->form,
                'model' => $this->model,
                'attribute' => $this->attribute,
                'timeFormats' => $this->timeFormats,
                'options' => $this->options,
                'hint' => $this->hint,
                'allowEmpty' => $this->allowEmpty,
            ],
            true
        );
    }

}
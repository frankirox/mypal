<?php

namespace common\widgets\DateFormatSelect;


use Yii;

class DateFormatSelect extends \yii\bootstrap\Widget
{

    public $model;
    public $form;
    public $options = ['class' => 'form-group select-field'];
    public $attribute;
    public $hint;
    public $allowEmpty =  false;

    public function init()
    {
        parent::init();
    }

    protected function getDateFormats()
    {
        $timestamp = strtotime(date("Y") . '-01-22');
        return [
            'medium' => Yii::$app->formatter->asDate($timestamp, "medium"),
            'long' => Yii::$app->formatter->asDate($timestamp, "long"),
            'full' => Yii::$app->formatter->asDate($timestamp, "full"),
            'yyyy-MM-dd' => Yii::$app->formatter->asDate($timestamp, "yyyy-MM-dd"),
            'dd/MM/yyyy' => Yii::$app->formatter->asDate($timestamp, "dd/MM/yyyy"),
            'MM/dd/yyyy' => Yii::$app->formatter->asDate($timestamp, "MM/dd/yyyy"),
            'dd.MM.yyyy' => Yii::$app->formatter->asDate($timestamp, "dd.MM.yyyy"),
        ];
    }

    public function run()
    {
        return $this->render(
            'DateFormatSelectField',
            [
                'form' => $this->form,
                'model' => $this->model,
                'attribute' => $this->attribute,
                'dateFormats' => $this->dateFormats,
                'options' => $this->options,
                'hint' => $this->hint,
                'allowEmpty' => $this->allowEmpty,
            ],
            true
        );
    }

}
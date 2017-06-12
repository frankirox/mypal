<?php

namespace common\widgets\TimezoneSelect;

class TimezoneSelect extends \yii\bootstrap\Widget
{

    public $model;
    public $form;
    public $options = ['class' => 'form-group select-field'];
    public $pluginOptions = [];
    public $attribute;
    public $timezones = [];
    public $hint;
    public $allowEmpty =  false;

    public function init()
    {
        parent::init();

        if(empty($this->timezones)){
            
            $list = \DateTimeZone::listIdentifiers();
            for ($i = 0; $i < count($list); $i++) {
                $this->timezones[$list[$i]] = $list[$i];
            }
        }

    }


    public function run()
    {
        return $this->render(
            'TimezoneSelectField',
            [
                'form' => $this->form,
                'model' => $this->model,
                'attribute' => $this->attribute,
                'timezones' => $this->timezones,
                'options' => $this->options,
                'pluginOptions' => $this->pluginOptions,
                'hint' => $this->hint,
                'allowEmpty' => $this->allowEmpty,
            ],
            true
        );
    }

}
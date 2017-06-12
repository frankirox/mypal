<?php

namespace common\widgets\LanguageSelect;

use Yii;

class LanguageSelect extends \yii\bootstrap\Widget
{

    public $id;
    public $model;
    public $form;
    public $pluginOptions = [];
    public $attribute;

    public $languages = array();

    public function init()
    {
        parent::init();
    }

    public function getLanguagesList()
    {
        return $this->languageIds;
    }

    public function run()
    {
        return $this->render(
            'LanguageSelectField',
            [
                'id' => $this->id,
                'form' => $this->form,
                'model' => $this->model,
                'attribute' => $this->attribute,
                'languageIds' => $this->languages,
                'pluginOptions' => $this->pluginOptions,
            ],
            true
        );
    }

}
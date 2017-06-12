<?php

namespace common\widgets\ProfilePicture;

class ProfilePicture extends  \yii\bootstrap\Widget
{

    public $model;
    public $attribute;
    public $webcamActionUrl;
    public $uploadActionUrl;
    public $saveActionUrl;
    public $imgReplacingClass = 'profile-picture';
    public $options = [];
    public $pluginOptions = [];

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render(
            'ProfilePicture',
            [
                'model'   => $this->model,
                'attribute' => $this->attribute,
                'options'   => $this->options,
                'webcamActionUrl'   => $this->webcamActionUrl,
                'uploadActionUrl'   => $this->uploadActionUrl,
                'saveActionUrl'   => $this->saveActionUrl,
                'imgReplacingClass' => $this->imgReplacingClass,
                'pluginOptions' => $this->pluginOptions,
            ]
        );
    }

}
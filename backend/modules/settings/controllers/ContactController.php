<?php

namespace backend\modules\settings\controllers;

use backend\modules\settings\controllers\SettingsBaseController;


class ContactController extends SettingsBaseController
{
    public $modelClass = 'backend\modules\settings\models\ContactSettings';
    public $viewPath = '@backend/modules/settings/views/contact/index';

}
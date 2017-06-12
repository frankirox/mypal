<?php

namespace backend\modules\settings\controllers;

use backend\modules\settings\controllers\SettingsBaseController;


class SocialController extends SettingsBaseController
{
    public $modelClass = 'backend\modules\settings\models\SocialSettings';
    public $viewPath = '@backend/modules/settings/views/social/index';

}
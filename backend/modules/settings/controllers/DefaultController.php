<?php

namespace backend\modules\settings\controllers;

/**
 * DefaultController implements General Settings page.
 *
 * @author Franchesco Fonseca <fonseca.franchesco@gmail.com>
 */
class DefaultController extends SettingsBaseController
{
    public $modelClass = 'backend\modules\settings\models\GeneralSettings';
    public $viewPath = '@backend/modules/settings/views/default/index';

}
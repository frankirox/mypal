<?php

namespace backend\controllers;


class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public $enableOnlyActions = ['index', 'error', 'maintenance'];
    public $widgets = null;

    public function actionIndex()
    {

        return $this->redirect(['/pet/default/index']);
    }

    public function actionMaintenance()
    {
        $this->layout = '//clean';

        return $this->render('maintenance');
    }

}

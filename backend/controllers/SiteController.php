<?php

namespace backend\controllers;

use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\base\UserException;
use yii\helpers\ArrayHelper;
use Yii;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

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

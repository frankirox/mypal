<?php

namespace api\controllers;

use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\base\UserException;
use yii\helpers\ArrayHelper;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public $enableOnlyActions = ['index','error'];

    public function actionIndex()
    {

        throw new NotFoundHttpException();
    }

}

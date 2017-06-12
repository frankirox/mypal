<?php

namespace api\modules\v1\components;

use yii\helpers\StringHelper;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\rest\UpdateAction;
use yii\web\ServerErrorHttpException;

class UpdateActiveAction extends UpdateAction
{

    public $permissionName = null;


    public function run($id)
    {

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, null, [], $this->permissionName);
        }

        /* @var $model \yii\db\ActiveRecord */
        $model = $this->findModel($id);
        $model->scenario = $this->scenario;

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $success = $model->save();

        if ($success) {

            $model->refresh();
            $response = Yii::$app->getResponse();
            $response->setStatusCode(200);
        } else {

            $response = Yii::$app->getResponse();
            $response->setStatusCode(200);
        }

        return $model;
    }
}

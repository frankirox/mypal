<?php

namespace api\modules\v1\components;

use yii\helpers\StringHelper;
use Yii;
use yii\rest\DeleteAction;
use yii\web\ServerErrorHttpException;


class DeleteActiveAction extends DeleteAction
{

    public $permissionName = null;

    public function run($id)
    {

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, null, [], $this->permissionName);
        }

        $model = $this->findModel($id);
        Yii::$app->getResponse()->setStatusCode(204);

        try {

            if ($model->delete()) {

                return true;
            }

        } catch (\Exception $e) {

            return false;
        }


        return false;

    }
}

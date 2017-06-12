<?php


namespace api\modules\v1\components;

use Yii;
use yii\helpers\Url;


class CreateActiveAction extends \yii\rest\CreateAction
{


    public $permissionName = null;


    public function run()
    {

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, null, [], $this->permissionName);
        }

        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $success = $model->save();

        if ($success) {

            $model->refresh();
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
        }

        return $model;
    }
}

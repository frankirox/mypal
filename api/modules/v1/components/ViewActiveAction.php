<?php

namespace api\modules\v1\components;

use yii\helpers\StringHelper;
use Yii;
use yii\rest\ViewAction;


class ViewActiveAction extends ViewAction
{

    public $permissionName = null;

    public function run($id)
    {

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, null, [], $this->permissionName);
        }

        $model = $this->findModel($id);

        return $model;
    }
}

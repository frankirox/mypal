<?php


namespace api\modules\v1\components;

use Yii;
use yii\rest\OptionsAction;


class OptionsActiveAction extends OptionsAction
{

    public $permissionName = null;

    public $permissionStore = false;

    public $checkAccess = null;

    public $GETPermission = null;
    public $HEADPermission = null;
    public $POSTPermission = null;
    public $PUTPermission = null;
    public $PATCHPermission = null;
    public $DELETEPermission = null;

    public function run($id = null)
    {

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        $collectionOptions = ['OPTIONS'];

        $resourceOptions = ['OPTIONS'];

        if(Yii::$app->user->can($this->GETPermission) && $this->GETPermission != null){

            $collectionOptions[] = 'GET';

            $resourceOptions[] = 'GET';

        }

        if(Yii::$app->user->can($this->HEADPermission) && $this->HEADPermission != null){

            $collectionOptions[] = 'HEAD';

            $resourceOptions[] = 'HEAD';

        }

        if(Yii::$app->user->can($this->POSTPermission) && $this->POSTPermission != null){


            $collectionOptions[] = 'POST';

            $resourceOptions[] = 'POST';

        }

        if(Yii::$app->user->can($this->PUTPermission) && $this->PUTPermission != null){


            $resourceOptions[] = 'PUT';

        }

        if(Yii::$app->user->can($this->PATCHPermission) && $this->PATCHPermission != null){


            $resourceOptions[] = 'PATCH';

        }

        if (Yii::$app->getRequest()->getMethod() !== 'OPTIONS') {
            Yii::$app->getResponse()->setStatusCode(405);
        }

        $options = $id === null ? $collectionOptions : $resourceOptions;

        Yii::$app->getResponse()->getHeaders()->set('Allow', implode(', ', $options));

        sort($options);

        return $options;

    }
}

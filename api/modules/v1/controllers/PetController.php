<?php

namespace api\modules\v1\controllers;


use common\models\Pet;
use api\modules\v1\components\CreateActiveAction;
use api\modules\v1\components\DeleteActiveAction;
use api\modules\v1\components\IndexActiveAction;
use api\modules\v1\components\OptionsActiveAction;
use api\modules\v1\components\UpdateActiveAction;
use api\modules\v1\components\ViewActiveAction;
use Yii;
use api\modules\v1\components\ActiveController;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

class PetController extends ActiveController
{


    public function init()
    {

        $this->modelClass = Pet::className();

        parent::init();
    }


    /**
     * @inheritdoc
     */
    public function actions()
    {

        return [
            'index' => [
                'class' => IndexActiveAction::className(),
                'orderDataProviderBy' => 'created_at',
                'orderDataProviderTo' => SORT_DESC,
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'permissionName' => 'viewPets',
            ],
            'view' => [
                'class' => ViewActiveAction::className(),
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'permissionName' => 'viewPets',
            ],
            'create' => [
                'class' => CreateActiveAction::className(),
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->createScenario,
                'permissionName' => 'createPets',
            ],
            'update' => [
                'class' => UpdateActiveAction::className(),
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->updateScenario,
                'permissionName' => 'editPets',
            ],
            'delete' => [
                'class' => DeleteActiveAction::className(),
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'permissionName' => 'deletePets',
            ],
            'options' => [
                'class' => OptionsActiveAction::className(),
                'checkAccess' => [$this, 'checkAccess'],
                'GETPermission' => 'viewPets',
                'HEADPermission' => 'viewPets',
                'POSTPermission' => 'createPets',
                'PUTPermission' => 'editPets',
                'PATCHPermission' => 'editPets',
                'DELETEPermission' => 'deletePets'

            ],
        ];
    }

}

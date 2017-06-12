<?php

namespace backend\modules\pet\controllers;

use backend\controllers\BaseController;
use common\models\search\PetSearch;
use common\models\User;
use yii\helpers\Json;

/**
 * PostController implements the CRUD actions for Post model.
 */
class DefaultController extends BaseController
{
    public $modelClass = 'common\models\Pet';
    public $modelSearchClass = 'common\models\search\PetSearch';
    public $enableOnlyActions = ['index','validate','create','update'];

    protected function getRedirectPage($action, $model = null)
    {

        switch ($action) {
            case 'update':
                return ['update', 'id' => $model->id];
                break;
            case 'create':
                return ['update', 'id' => $model->id];
                break;
            default:
                return parent::getRedirectPage($action, $model);
        }
    }
}
<?php

namespace backend\modules\user\controllers;

use backend\controllers\BaseController;
use common\models\AuthItemGroup;
use backend\modules\user\models\search\AuthItemGroupSearch;

/**
 * AuthItemGroupController implements the CRUD actions for AuthItemGroup model.
 */
class PermissionGroupsController extends BaseController
{
    /**
     * @var AuthItemGroup
     */
    public $modelClass = 'common\models\AuthItemGroup';

    /**
     * @var AuthItemGroupSearch
     */
    public $modelSearchClass = 'backend\modules\user\models\search\AuthItemGroupSearch';

    public $disabledActions = ['view'];

    /**
     * Define redirect page after update, create, delete, etc
     *
     * @param string $action
     * @param AuthItemGroup $model
     *
     * @return string|array
     */
    protected function getRedirectPage($action, $model = null)
    {
        switch ($action) {
            case 'delete':
                return ['index'];
                break;
            case 'create':
                return ['update', 'id' => $model->code];
                break;
            default:
                return ['index'];
        }
    }
}
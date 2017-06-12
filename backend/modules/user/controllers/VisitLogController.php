<?php

namespace backend\modules\user\controllers;

use backend\controllers\BaseController;

/**
 * UserVisitLogController implements the CRUD actions for UserVisitLog model.
 */
class VisitLogController extends BaseController
{
    /**
     *
     * @inheritdoc
     */
    public $modelClass = 'common\models\UserVisitLog';

    /**
     *
     * @inheritdoc
     */
    public $modelSearchClass = 'backend\modules\user\models\search\UserVisitLogSearch';

    /**
     *
     * @inheritdoc
     */
    public $enableOnlyActions = ['index', 'view', 'grid-page-size'];

}
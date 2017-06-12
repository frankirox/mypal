<?php

namespace backend\modules\menu\controllers;

use backend\controllers\BaseController;
use Yii;
use yii\helpers\StringHelper;
use common\helpers\MirandaHelper;
use common\models\interfaces\OwnerAccess;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use common\models\MenuLink;

/**
 * MenuController implements the CRUD actions for Post model.
 */
class DefaultController extends BaseController
{
    public $modelClass = 'common\models\Menu';
    public $modelSearchClass = 'backend\modules\menu\models\search\SearchMenu';
    public $modelLinkSearchClass = 'backend\modules\menu\models\search\SearchMenuLink';
    public $disabledActions = ['view', 'bulk-activate', 'bulk-deactivate', 'toggle-attribute'];

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'save-orders' => ['post'],
                ],
            ],
        ]);
    }

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

    /**
     * Lists all models.
     * @return mixed
     */
    public function actionIndex()
    {
        $modelClass = $this->modelClass;
        $searchModel = $this->modelSearchClass ? new $this->modelSearchClass : null;
        $searchLinkModel = $this->modelLinkSearchClass ? new $this->modelLinkSearchClass : null;

        if ($searchModel) {
            $searchName = StringHelper::basename($searchModel::className());
            $params = Yii::$app->request->getQueryParams();
            $dataProvider = $searchModel->search($params);
        } else {
            $dataProvider = new ActiveDataProvider(['query' => $modelClass::find()]);
        }

        return $this->renderIsAjax('index', compact('dataProvider', 'searchModel', 'searchLinkModel'));
    }

    public function actionSaveOrders()
    {
        if (Yii::$app->getRequest()->isAjax) {
            $n = 1;
            $params = [];
            $select = [];
            $db = Yii::$app->db;
            $settings = Yii::$app->getRequest()->post('settings');

            foreach ($settings as $setting) {
                $select[] = "SELECT :id_{$n} as 'id', :order_{$n} as 'order', :parent_{$n} as 'parent_id', :target{$n} as 'target'";
                $params[":id_{$n}"] = $setting[0];
                $params[":order_{$n}"] = (int)$setting[1];
                $params[":parent_{$n}"] = (isset($setting[2])) ? $setting[2] : '';
                $params[":target{$n}"] = (isset($setting[3])) ? $setting[3] : '';
                //$params[":target{$n}"] = $setting[3];
                $n++;
            }

            $select = implode(' UNION ', $select);
            $menuLinkTable = MenuLink::tableName();
            $db->createCommand("UPDATE $menuLinkTable m INNER JOIN ($select)t ON m.id=t.id "
                . " SET m.order=t.order, m.parent_id=t.parent_id", $params)->execute();

        }

        return false;
    }
}
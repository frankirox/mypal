<?php

namespace backend\controllers;

use common\helpers\MirandaHelper;
use common\models\interfaces\OwnerAccess;
use common\models\Role;
use common\models\Route;
use common\models\User;
use common\widgets\ActiveForm;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use common\db\ActiveRecord;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use yii\web\Response;

abstract class BaseController extends \common\controllers\BaseController
{

    //used by layout
    public $minibar = false;

    public $breadcrumbs = true;

    /**
     * @var ActiveRecord
     */
    public $modelClass;

    /**
     * @var ActiveRecord
     */
    public $modelSearchClass;

    /**
     * Actions that will be disabled
     *
     * List of available actions:
     *
     * ['index', 'view', 'create', 'update', 'delete', 'toggle-attribute',
     * 'bulk-activate', 'bulk-deactivate', 'bulk-delete', 'grid-sort', 'grid-page-size']
     *
     * @var array
     */
    public $disabledActions = [];

    /**
     * Opposite to $disabledActions. Every action from AdminDefaultController except those will be disabled
     *
     * But if action listed both in $disabledActions and $enableOnlyActions
     * then it will be disabled
     *
     * @var array
     */
    public $enableOnlyActions = [];

    /**
     * List of actions in this controller. Needed fo $enableOnlyActions
     *
     * @var array
     */
    protected $_implementedActions = [
        'index',
        'view',
        'create',
        'update',
        'delete',
        'toggle-attribute',
        'bulk-activate',
        'bulk-deactivate',
        'bulk-delete',
        'grid-sort',
        'grid-page-size'
    ];

    /**
     * Layout file for admin panel
     *
     * @var string
     */
    public $layout = '@backend/views/layouts/main.php';


    /**
     * Index page view
     *
     * @var string
     */
    public $indexView = 'index';

    /**
     * View page view
     *
     * @var string
     */
    public $viewView = 'view';

    /**
     * Create page view
     *
     * @var string
     */
    public $createView = 'create';

    /**
     * Update page view
     *
     * @var string
     */
    public $updateView = 'update';


    public $error = null;


    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ]);
    }

    /**
     * function to validate forms by using ajax
     * @param integer $id
     * @return mixed
     */
    public function actionValidate($id = null)
    {
        $this->layout = false;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $modelClass = $this->modelClass;
        $className = StringHelper::basename($modelClass::className());

        if ($id == null && isset($_POST[$className]['id'])) {
            $id = $_POST[$className]['id'];
        }

        if ($id != null) {
            $model = $modelClass->findModel($id);
            $model->isNewRecord = false;
        } else {

            $model = new $modelClass;
        }

        $model->load(Yii::$app->request->post());

        return ActiveForm::validate($model);
    }

    /**
     * Lists all models.
     * @return mixed
     */
    public function actionIndex()
    {

        $modelClass = $this->modelClass;
        $searchModel = $this->modelSearchClass ? new $this->modelSearchClass : null;

        if ($searchModel) {

            $searchName = StringHelper::basename($searchModel::className());
            $params = Yii::$app->request->getQueryParams();
            $dataProvider = $searchModel->search($params);

        } else {

            $dataProvider = new ActiveDataProvider(['query' => $modelClass::find()]);
        }


        return $this->renderIsAjax($this->indexView, compact('dataProvider', 'searchModel'));
    }

    /**
     * Displays a single model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderIsAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /* @var $model \common\db\ActiveRecord */
        $model = new $this->modelClass;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('crudMessage', Yii::t('miranda', 'The information has been registered.'));
            return $this->redirect($this->getRedirectPage('create', $model));
        }

        return $this->renderIsAjax($this->createView, compact('model'));
    }

    /**
     * Updates an existing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        /* @var $model \common\db\ActiveRecord */
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) AND $model->save()) {
            Yii::$app->session->setFlash('crudMessage', Yii::t('miranda', 'The information has been updated.'));
            return $this->redirect($this->getRedirectPage('update', $model));
        }

        return $this->renderIsAjax($this->updateView, compact('model'));
    }

    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        /* @var $model \common\db\ActiveRecord */
        $model = $this->findModel($id);

        try {

            if ($model->delete()) {

                Yii::$app->session->setFlash('crudMessage', Yii::t('miranda', 'The information has been deleted.'));
            }

        } catch (\Exception $e) {

            Yii::$app->session->setFlash('crudMessage', Yii::t('miranda', 'The information can not be deleted.'));
        }


        return $this->redirect($this->getRedirectPage('delete', $model));
    }

    /**
     * @param string $attribute
     * @param int $id
     */
    public function actionToggleAttribute($attribute, $id)
    {
        //TODO: Restrict owner access
        /* @var $model \common\db\ActiveRecord */
        $model = $this->findModel($id);
        $model->{$attribute} = ($model->{$attribute} == 1) ? 0 : 1;
        $model->save(false);
    }

    /**
     * Activate all selected grid items
     */
    public function actionBulkActivate()
    {
        if (Yii::$app->request->post('selection')) {

            $modelClass = $this->modelClass;
            $where = ['id' => Yii::$app->request->post('selection', [])];
            $modelClass::updateAll(['status' => 1], $where);
        }
    }

    /**
     * Deactivate all selected grid items
     */
    public function actionBulkDeactivate()
    {
        if (Yii::$app->request->post('selection')) {

            $modelClass = $this->modelClass;
            $where = ['id' => Yii::$app->request->post('selection', [])];
            $modelClass::updateAll(['status' => 0], $where);
        }
    }

    /**
     * Deactivate all selected grid items
     */
    public function actionBulkDelete()
    {
        if (Yii::$app->request->post('selection')) {
            $modelClass = $this->modelClass;

            foreach (Yii::$app->request->post('selection', []) as $id) {

                $model = $modelClass::findOne(['id' => $id]);
                if ($model) {
                    $model->delete();
                }
            }
        }
    }

    /**
     * Sorting items in grid
     */
    public function actionGridSort()
    {
        if (Yii::$app->request->post('sorter')) {
            $sortArray = Yii::$app->request->post('sorter', []);

            $modelClass = $this->modelClass;

            $models = $modelClass::findAll(array_keys($sortArray));

            foreach ($models as $model) {
                $model->sorter = $sortArray[$model->id];
                $model->save(false);
            }
        }
    }

    /**
     * Set page size for grid
     */
    public function actionGridPageSize()
    {
        if (Yii::$app->request->post('grid-page-size')) {
            $cookie = new Cookie([
                'name' => '_grid_page_size',
                'value' => Yii::$app->request->post('grid-page-size'),
                'expire' => time() + 86400 * 365, // 1 year
            ]);

            Yii::$app->response->cookies->add($cookie);
        }
    }

    /**
     * Finds the model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param mixed $id
     * @return ActiveRecord the loaded model
     * @throws InvalidConfigException
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $modelClass = $this->modelClass;
        $model = new $modelClass;

        if (method_exists($model, 'isMultilingual') && $model->isMultilingual()) {
            $condition = [];
            $primaryKey = $modelClass::primaryKey();
            $query = $modelClass::find();

            if (isset($primaryKey[0])) {
                $condition = [$primaryKey[0] => $id];
            } else {
                throw new InvalidConfigException('"' . $modelClass . '" must have a primary key.');
            }

            $model = $query->andWhere($condition)->multilingual()->one();
        } else {
            $model = $modelClass::findOne($id);
        }

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
    }

    /**
     * Define redirect page after update, create, delete, etc
     *
     * @param string $action
     * @param ActiveRecord $model
     *
     * @return string|array
     */
    protected function getRedirectPage($action, $model = null)
    {
        switch ($action) {
            case 'delete':
                return ['index'];
                break;
            case 'update':
                return ['view', 'id' => $model->id];
                break;
            case 'create':
                return ['view', 'id' => $model->id];
                break;
            default:
                return ['index'];
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {

        if (parent::beforeAction($action)) {

            if ($this->enableOnlyActions !== [] AND in_array($action->id, $this->_implementedActions) AND
                !in_array($action->id, $this->enableOnlyActions)
            ) {
                throw new NotFoundHttpException('Page not found');
            }

            if (in_array($action->id, $this->disabledActions)) {
                throw new NotFoundHttpException('Page not found');
            }

            return true;
        }

        return false;
    }


    /**
     * Write in sessions alert messages
     * @param string $type error or success
     * @param string $message alert body
     */
    public function flash($type, $message)
    {
        Yii::$app->getSession()->setFlash($type == 'error' ? 'danger' : $type, $message);
    }

    public function back()
    {
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Set return url for module in sessions
     * @param mixed $url if not set, returnUrl will be current page
     */
    public function setReturnUrl($url = null)
    {
        Yii::$app->getSession()->set($this->module->id . '_return', $url ? Url::to($url) : Url::current());
    }

    /**
     * Get return url for module from session
     * @param mixed $defaultUrl if return url not found in sessions
     * @return mixed
     */
    public function getReturnUrl($defaultUrl = null)
    {
        return Yii::$app->getSession()->get($this->module->id . '_return',
            $defaultUrl ? Url::to($defaultUrl) : Url::to('/admin/' . $this->module->id));
    }

    /**
     * Formats response depending on request type (ajax or not)
     * @param string $success
     * @param bool $back go back or refresh
     * @return mixed $result array if request is ajax.
     */
    public function formatResponse($success = '', $back = true)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($this->error) {
                return ['result' => 'error', 'error' => $this->error];
            } else {
                $response = ['result' => 'success'];
                if ($success) {
                    if (is_array($success)) {
                        $response = array_merge(['result' => 'success'], $success);
                    } else {
                        $response = array_merge(['result' => 'success'], ['message' => $success]);
                    }
                }
                return $response;
            }
        } else {
            if ($this->error) {
                $this->flash('error', $this->error);
            } else {
                if (is_array($success) && isset($success['message'])) {
                    $this->flash('success', $success['message']);
                } elseif (is_string($success)) {
                    $this->flash('success', $success);
                }
            }
            return $back ? $this->back() : $this->refresh();
        }
    }
}
<?php

namespace backend\modules\user\controllers;

use backend\controllers\BaseController;
use backend\modules\user\forms\CreateUserForm;
use backend\modules\user\forms\UpdateUserForm;
use common\models\User;
use common\models\Profile;
use Yii;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use common\models\Permission;
use common\models\Role;

/**
 * DefaultController implements the CRUD actions for User model.
 */
class DefaultController extends BaseController
{
    /**
     * @var User
     */
    public $modelClass = 'common\models\User';

    /**
     * @var UserSearch
     */
    public $modelSearchClass = 'backend\modules\user\models\search\UserSearch';

    public $disabledActions = ['view'];


    /**
     * @return mixed|string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new CreateUserForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            return $this->redirect(['/user/default/index']);
        }

        return $this->renderIsAjax('create', compact('model'));
    }

    /**
     * @return mixed|string|\yii\web\Response
     */
    public function actionUpdate($id)
    {

        $user = $this->findModel($id);
        $model = new UpdateUserForm();
        $model->setAttributes($user->attributes);
        $model->setAttributes($user->profile->attributes);


        if ($model->load(Yii::$app->request->post()) AND $model->save()) {

            Yii::$app->session->setFlash('crudMessage', 'Your item has been updated.');
            return $this->redirect(['/user/default/index']);
        }

        return $this->renderIsAjax('update', compact('model'));

    }

    /**
     * @param int $id User ID
     *
     * @throws \yii\web\NotFoundHttpException
     * @return string
     */
    public function actionChangePassword($id)
    {

        $model = User::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException(Yii::t('miranda/user', 'User not found'));
        }

        $model->scenario = 'changePassword';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('crudMessage', Yii::t('miranda/auth', 'Password has been updated'));
            return $this->redirect(['/user/default/index']);
        }

        return $this->renderIsAjax('changePassword', compact('model'));
    }
}
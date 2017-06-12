<?php

namespace api\modules\v1\controllers;


use api\modules\v1\forms\LoginForm;
use common\models\Profile;
use Yii;
use api\modules\v1\components\Controller;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use yii\web\Response;

class AuthController extends Controller
{

    protected function verbs()
    {
        return [
            'login' => ['POST'],
            'view-account' => ['GET', 'HEAD'],
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['view-account'],
        ];

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['view-account'],
            'rules' => [
                [
                    'actions' => ['view-account'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];

        return $behaviors; // TODO: Change the autogenerated stub
    }

    public function actionIndex()
    {

        throw new NotFoundHttpException();
    }

    public function actionError()
    {

        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {

            $code = 400;
            $message = 'Bad Request';

        } else {

            $code = (isset($exception->statusCode) ? $exception->statusCode : $exception->getCode());
            $message = (method_exists($exception, 'getMessage') ? $exception->getMessage() : Yii::t('yii',
                'An internal server error occurred.'));
        }

        Yii::$app->response->setStatusCode($code, $message);

        return [
            'code' => $code,
            'message' => $message,
        ];

    }

    public function actionLogin()
    {

        $model = new LoginForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {

            return [
                'access_token' => Yii::$app->user->identity->getAuthKey(),
            ];
        } else {

            $model->validate();
            return $model;
        }
    }


    public function actionViewAccount()
    {

        $user = Yii::$app->user->identity;

        if ($user instanceof User && $user->profile instanceof Profile) {


            return [
                'data' => $user->getAttributes([
                        'email',
                        'username'
                    ]) + $user->profile->getAttributes([
                        'first_name',
                        'last_name',
                        'country',
                        'timezone',
                        'language',
                    ])
            ];

        }

        throw new NotFoundHttpException();

    }


}
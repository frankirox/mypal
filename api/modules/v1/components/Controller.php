<?php

namespace api\modules\v1\components;


use api\modules\v1\Module;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\RateLimiter;
use yii\filters\VerbFilter;
use yii\rest\Controller as BaseController;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;


/**
 *  Base Controller.
 *
 *
 * @property Module $module
 */
class Controller extends BaseController
{


    /**
     * Checks the privilege of the current user.
     *
     * If the user does not have access, a [[ForbiddenHttpException]] should be thrown.
     *
     * @param string $permission
     * @throws ForbiddenHttpException if the user does not have access
     * @internal param bool $store_permission
     */
    public function checkAccess($permission = null)
    {


        if (Yii::$app->user->isGuest) {

            throw new ForbiddenHttpException();
        }

        if ($permission != null) {

            if (!Yii::$app->user->identity->hasPermission($permission)) {

                throw new ForbiddenHttpException();
            }
        }


    }


    public function afterAction($action, $result)
    {

        $parentAfterActionEvent = parent::afterAction($action, $result);

        $this->module->terminateRestUserConnection();

        return $parentAfterActionEvent;
    }

}
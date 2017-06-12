<?php

namespace backend\modules\auth;

use Yii;
use yii\base\Exception;


class AuthAction extends \yii\authclient\AuthAction
{

    /**
     * Runs the action.
     */
    public function run()
    {
        try {
            return parent::run();
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('error', $ex->getMessage());
            //Yii::$app->session->setFlash('error', Yii::t('miranda/auth', "Authentication error occured."));

            return $this->redirectCancel();
        }
    }
}
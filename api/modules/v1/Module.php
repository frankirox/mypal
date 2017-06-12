<?php

namespace api\modules\v1;

use api\modules\v1\components\ErrorHandler;
use common\models\User;
use common\models\UserAccessToken;
use Yii;
use yii\helpers\Url;
use yii\web\Response;

class Module extends \yii\base\Module
{

    public $defaultRoute = 'auth';
    public $controllerNamespace = 'api\modules\v1\controllers';


    public function init()
    {

        parent::init();
        Yii::$app->user->enableSession = false;
        Yii::$app->user->loginUrl = null;

        $handler = new ErrorHandler();
        \Yii::$app->set('errorHandler', $handler);
        $handler->register();

    }

    public function createUserAccessToken($username, $password)
    {

        $user = User::find()->where(['username' => $username])->one();

        if ($user instanceof User) {


            if ($user->status == User::STATUS_ACTIVE) {

                $passwordMatch = false;

                if ($user->validatePassword($password)) {

                    $passwordMatch = true;
                }

                if ($passwordMatch) {

                    //disable any already existent active key
                    $existentUserKey = UserAccessToken::findActiveByUser($user->id, UserAccessToken::TYPE_REST_CLIENT);

                    if ($existentUserKey instanceof UserAccessToken) {

                        $existentUserKey->consume();
                        $existentUserKey->expire();
                    }

                    $userKey = UserAccessToken::generate($user->id, UserAccessToken::TYPE_REST_CLIENT);

                    if ($userKey instanceof UserAccessToken) {

                        return $userKey->key;
                    }
                }

            }


        }

        return null;
    }

    public function disableUserAccessToken($user_key)
    {


        $existentUserAccessToken = UserAccessToken::findActiveByKey($user_key, UserAccessToken::TYPE_REST_CLIENT);

        if ($existentUserAccessToken instanceof UserAccessToken) {

            $existentUserAccessToken->consume();
            $existentUserAccessToken->expire();

            return true;

        }

        return false;
    }


    public function validateUserAccessToken()
    {

        if (isset($_GET['token'])) {

            if (!empty($_GET['token'])) {

                $userAccessToken = UserAccessToken::findActiveByKey($_GET['token'], UserAccessToken::TYPE_REST_CLIENT);

                if ($userAccessToken instanceof UserAccessToken) {

                    $user = $userAccessToken->user;

                    if ($user instanceof User) {

                        if ($user->status == User::STATUS_ACTIVE) {

                            $currentDateTime = new \DateTime('NOW');
                            $userAccessTokenExpireDateTime = new \DateTime($userAccessToken->expires_at);
                            $userAccessTokenIsExpired = true;

                            if (empty($userAccessToken->expires_at)) {

                                $userAccessTokenIsExpired = false;

                            } else {

                                if ($currentDateTime < $userAccessTokenExpireDateTime) {

                                    $userAccessTokenIsExpired = false;
                                }
                            }

                            if (!$userAccessTokenIsExpired) {

                                return true;

                            }

                        }

                    }

                }
            }


        }

        return false;
    }

    public function initializeRestUserConnection()
    {

        if ($this->validateUserAccessToken()) {

            $identity = User::findIdentityByAccessToken($_GET['token'], UserAccessToken::TYPE_REST_CLIENT);

            if ($identity instanceof User) {


                return Yii::$app->user->login($identity);
            }

        }
        return false;
    }

    public function terminateRestUserConnection()
    {

        if (!Yii::$app->user->isGuest) {

            Yii::$app->user->logout();
        }
    }
}

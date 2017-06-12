<?php

namespace backend\modules\translation\controllers;

use backend\controllers\BaseController;
use common\models\User;
use backend\modules\translation\models\Message;
use backend\modules\translation\models\MessageSource;
use Yii;
use yii\base\Model;

/**
 * MessageController implements the CRUD actions for backend\modules\translation\models\Message model.
 */
class DefaultController extends BaseController
{
    public $modelClass = 'backend\modules\translation\models\Message';
    public $enableOnlyActions = ['index'];

    /**
     * Lists all models.
     * @return mixed
     */
    public function actionIndex()
    {
        $sourceLanguage = 'en-US';

        $languages = Yii::$app->miranda->languages;
        $categories = MessageSource::getMessageCategories();

        unset($languages[$sourceLanguage]);

        $currentLanguage = Yii::$app->getRequest()->get('translation', null);
        $currentCategory = Yii::$app->getRequest()->get('category', null);

        if (!in_array($currentLanguage, array_keys($languages))) {
            $currentLanguage = null;
        }

        if (!in_array($currentCategory, array_keys($categories))) {
            $currentCategory = null;
        }

        if ($currentLanguage && $currentCategory) {

            Message::initMessages($currentCategory, $currentLanguage);

            $messageIds = MessageSource::getMessageIdsByCategory($currentCategory);
            $sourceTable = MessageSource::tableName();
            $messageTable = Message::tableName();

            $messages = Message::find()
                ->andWhere(['IN', 'source_id', $messageIds])
                ->andWhere(['language' => $currentLanguage])
                ->indexBy('id')
                ->all();
        } else {
            $messages = [];
        }

        if (User::hasPermission('updateTranslations') && Message::loadMultiple($messages, Yii::$app->request->post())
            && Model::validateMultiple($messages)
        ) {
            foreach ($messages as $message) {
                $message->save(false);
            }

            Yii::$app->session->setFlash('crudMessage', 'Your item has been updated.');
            return $this->refresh();
        }

        return $this->render('index', [
            'messages' => $messages,
            'languages' => $languages,
            'categories' => $categories,
            'currentLanguage' => $currentLanguage,
            'currentCategory' => $currentCategory,
        ]);
    }
}
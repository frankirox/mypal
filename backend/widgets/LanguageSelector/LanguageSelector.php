<?php

namespace backend\widgets\LanguageSelector;

use Yii;
use yii\helpers\ArrayHelper;

class LanguageSelector extends \yii\base\Widget
{

    public function run()
    {
        if (!Yii::$app->miranda->isMultilingual) {
            return;
        }

        $language = Yii::$app->language;
        $languages = Yii::$app->miranda->displayLanguages;

        list($route, $params) = Yii::$app->getUrlManager()->parseRequest(Yii::$app->getRequest());
        $params = ArrayHelper::merge(Yii::$app->getRequest()->get(), $params);
        $url = isset($params['route']) ? $params['route'] : $route;

        return $this->render("selector", [
            'language' => $language,
            'languages' => $languages,
            'url' => $url,
            'params' => $params,
        ]);
    }
}
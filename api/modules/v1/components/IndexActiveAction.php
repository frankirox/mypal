<?php

namespace api\modules\v1\components;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\rest\IndexAction;


class IndexActiveAction extends IndexAction
{


    public $orderDataProviderBy = null;
    public $orderDataProviderTo = SORT_ASC;
    public $permissionName = null;


    public function run()
    {

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, null, [], $this->permissionName);
        }

        return $this->prepareDataProvider();
    }

    protected function prepareDataProvider()
    {
        if ($this->prepareDataProvider !== null) {
            return call_user_func($this->prepareDataProvider, $this);
        }

        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelInstance = new $this->modelClass;
        $modelClass = $this->modelClass;

        if (!empty($this->orderDataProviderBy) && array_key_exists($this->orderDataProviderBy,
                $modelInstance->attributes)
        ) {
            return new ActiveDataProvider([
                'query' => $modelClass::find(),
                'sort' => ['defaultOrder' => [$this->orderDataProviderBy => $this->orderDataProviderTo]],
                'pagination' => false,
            ]);
        }

        return new ActiveDataProvider([
            'query' => $modelClass::find(),
            'pagination' => false,
        ]);
    }
}

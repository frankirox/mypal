<?php
namespace common\behaviors;

use Yii;

/**
 * Status behavior. Adds statuses to models
 * @package yii\easyii\behaviors
 */
class StatusBehavior extends \yii\base\Behavior
{
    public $model;

    public function changeStatus($id, $status)
    {
        $modelClass = $this->model;

        if(($model = $modelClass::findOne($id))){
            $model->status = $status;
            $model->update();
        }
        else{
            $this->error = Yii::t('easyii', 'Not found');
        }

        return $this->owner->formatResponse(Yii::t('miranda', 'Status successfully changed'));
    }
}
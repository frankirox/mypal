<?php

use yii\helpers\Html;
use backend\modules\post\form\CreateMediaForm;

/* @var $this yii\web\View */
/* @var $model common\models\Pet */

$this->title = Yii::t('miranda', 'Update "{item}"', ['item' => "{$model->breed} {$model->name} #{$model->id}"]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('miranda/pet', 'Pets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => "{$model->breed} {$model->name} #{$model->id}",
    'url' => ['view', 'id' => $model->id]
];
$this->params['breadcrumbs'][] = Yii::t('miranda', 'Update');
?>

<div class="post-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>



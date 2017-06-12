<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Pet */

$this->title = Yii::t('miranda', 'Create {item}', ['item' => Yii::t('miranda/pet', 'Pet')]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('miranda/pet', 'Pets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pet-create">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>

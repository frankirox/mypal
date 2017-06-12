<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\modules\menu\models\search\SearchMenuLink */

$this->title = Yii::t('miranda/menu', 'Create Menu Link');
$this->params['breadcrumbs'][] = ['label' => Yii::t('miranda/menu', 'Menus'), 'url' => ['/menu/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="menu-link-create">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>
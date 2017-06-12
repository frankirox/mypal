<?php
use common\components\Miranda;

/* @var $this yii\web\View */
?>

<div class="pull-<?= $position ?> col-lg-<?= $width ?> widget-height-<?= $height ?>">
    <div class="panel panel-default">
        <div class="panel-heading"><?= Yii::t('miranda', 'System Info') ?></div>
        <div class="panel-body">
            <b><?= Yii::t('miranda', 'Miranda CMS Version') ?>:</b> <?= Yii::$app->params['version']; ?><br/>
            <b><?= Yii::t('miranda', 'Miranda Core Version') ?>:</b> <?= Miranda::getVersion(); ?><br/>
            <b><?= Yii::t('miranda', 'Yii Framework Version') ?>:</b> <?= Yii::getVersion(); ?><br/>
            <b><?= Yii::t('miranda', 'PHP Version') ?>:</b> <?= phpversion(); ?><br/>
        </div>
    </div>
</div>
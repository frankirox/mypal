<?php

/**
 * @var yii\web\View $this
 * @var common\models\User $user
 */

$this->title = Yii::t('miranda/auth', 'E-mail confirmed');
?>
<div class="change-own-password-success">

    <div class="alert alert-success text-center">
        <?= Yii::t('miranda/auth', 'E-mail confirmed') ?> - <b><?= $user->email ?></b>
    </div>

</div>

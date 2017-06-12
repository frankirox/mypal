<?php

/**
 * @var yii\web\View $this
 * @var common\models\User $user
 */

$this->title = Yii::t('miranda/auth', 'Registration - confirm your e-mail');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registration-wait-for-confirmation" style="margin-top: 6%;">

    <div class="alert alert-info text-center">
        <?= Yii::t('miranda/auth', 'Check your e-mail {email} for instructions to activate account', [
            'email' => '<b>' . $user->email . '</b>'
        ]) ?>
    </div>

</div>

<?php
/**
 * @var $this yii\web\View
 * @var $user common\models\User
 */
use yii\helpers\Html;

$resetLink = Yii::$app->urlManager->createAbsoluteUrl([
    '/auth/default/reset-password-request',
    'token' => $user->confirmation_token
]);
?>

<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to reset your password:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
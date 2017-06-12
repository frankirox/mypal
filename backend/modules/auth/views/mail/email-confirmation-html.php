<?php
/**
 * @var $this yii\web\View
 * @var $user common\models\User
 */
use yii\helpers\Html;

?>
<?php
$link = Yii::$app->urlManager->createAbsoluteUrl(['/auth/default/confirm-email-receive', 'token' => $user->confirmation_token]);
?>


<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p><?= Yii::t("user", "Please confirm your email address by clicking the link below:") ?></p>

    <p><?= Html::a(Html::encode($link), $link) ?></p>
</div>
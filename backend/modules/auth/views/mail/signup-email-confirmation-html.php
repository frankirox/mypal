<?php
/**
 * @var $this yii\web\View
 * @var $user common\models\User
 */
use yii\helpers\Html;

?>
<?php
$returnUrl = Yii::$app->user->returnUrl == Yii::$app->homeUrl ? null : rtrim(Yii::$app->homeUrl, '/') . Yii::$app->user->returnUrl;

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['/auth/default/confirm-registration-email', 'token' => $user->confirmation_token, 'returnUrl' => $returnUrl]);
?>

    <?= Yii::t('miranda/auth', 'Hello, you have been registered on'); ?> <?= Yii::$app->urlManager->hostInfo ?>

    <br/><br/>

    <?= Yii::t('miranda/auth', 'Follow this link to confirm your E-mail and activate account:'); ?>

<?= Html::a('confirm E-mail', $confirmLink) ?>
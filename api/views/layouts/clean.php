<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use backend\widgets\Alert;

\backend\assets\AppAsset::register($this);
//yiister\gentelella\assets\Asset::register($this);
//backend\assets\CustomGentelellaAsset::register($this)

/*
 * useful stuff:
 *
 * Yii::$app->controller->module->id Yii::$app->controller->id
 *
 * */

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="<?= Yii::$app->homeUrl ?>/favicon.ico" type="image/x-icon" />
    <?php $this->head() ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body style="background-color: #f2f2f2">

<?=
ercling\pace\PaceWidget::widget(
    [
        'color' => 'blue',
        'theme' => 'minimal',
        'options' => [
            'ajax' => ['trackMethods' => ['GET', 'POST']]
        ]
    ]
)
?>

<?php $this->beginBody(); ?>
<div class="container body">

    <div class="main_container">

        <?= $content ?>
    </div>

</div>

<!-- /footer content -->
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>

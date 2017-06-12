<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use backend\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$assetBundle = AppAsset::register($this);
$logo = $assetBundle->baseUrl . '/images/admin-icon-128.png';
$background = $assetBundle->baseUrl . '/images/congruent_pentagon.png';

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login" style="background: transparent url(<?= $background ?>); background-repeat: repeat;">

<?php $this->beginBody(); ?>

<div class="container body">

    <div class="main_container">

        <div style="padding-left: 5%; padding-right: 5%; padding-top: 5%; padding-bottom: 1%;">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 id="login-title"><?= Html::img($logo, ['class' => 'admin-logo', 'alt' => Yii::$app->name ]) ?>
                        <?= Yii::$app->name ?> <span style="font-size: 12px"><?= \common\components\Miranda::VERSION ?></span>
                    </h1>
                </div>
            </div>
        </div>

        <?= $content ?>

        <?= \common\components\Miranda::poweredBlock() ?>

    </div>
</div>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>

<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use backend\assets\AppAsset;
use backend\modules\auth\assets\AvatarAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$assetBundle = AppAsset::register($this);
$logo = $assetBundle->baseUrl . '/images/admin-icon-32.png';
$avatar = ($userAvatar = Yii::$app->user->identity->profile->getAvatarUrl('large')) ? $userAvatar : AvatarAsset::getDefaultAvatar('large');

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
<body class="<?= (Yii::$app->controller->minibar? "nav-sm" : "nav-md") ?>">

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

        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0;">
                    <a href="<?= Yii::$app->urlManager->baseUrl ?>" class="site_title">
                        <?= Html::img($logo, ['class' => 'admin-logo', 'alt' => 'Miranda CMS']) ?>
                        <span style="font-weight: bold;"><?= Yii::$app->name ?></span>
                    </a>
                </div>
                <div class="clearfix"></div>

                <!-- menu prile quick info -->
                <div class="profile" style="margin-bottom: 90px;">
                    <div class="profile_pic">
                        <img src="<?= $avatar ?>" alt="Profile" class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span><?= Yii::t('miranda', 'Welcome') ?>,</span>
                        <h2><?= Yii::$app->user->identity->profile->fullName ?></h2>
                    </div>
                </div>
                <!-- /menu prile quick info -->


                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                    <div class="menu_section">

                        <?php
                        echo backend\widgets\Menu::widget(
                            [
                                'items' => \common\models\Menu::getMenuItems('admin-menu'),
                            ]
                        );
                        ?>
                        <?php
                        backend\widgets\Menu::widget(
                            [
                                "items" => [
                                    ["label" => "Home", "url" => "/", "icon" => "home"],
                                    ["label" => "Layout", "url" => ["site/layout"], "icon" => "files-o"],
                                    ["label" => "Error page", "url" => ["site/error-page"], "icon" => "close"],
                                    [
                                        "label" => "Widgets",
                                        "icon" => "th",
                                        "url" => "#",
                                        "items" => [
                                            ["label" => "Menu", "url" => ["site/menu"]],
                                            ["label" => "Panel", "url" => ["site/panel"]],
                                        ],
                                    ],
                                    [
                                        "label" => "Badges",
                                        "url" => "#",
                                        "icon" => "table",
                                        "items" => [
                                            [
                                                "label" => "Default",
                                                "url" => "#",
                                                "badge" => "123",
                                            ],
                                            [
                                                "label" => "Success",
                                                "url" => "#",
                                                "badge" => "new",
                                                "badgeOptions" => ["class" => "label-success"],
                                            ],
                                            [
                                                "label" => "Danger",
                                                "url" => "#",
                                                "badge" => "!",
                                                "badgeOptions" => ["class" => "label-danger"],
                                            ],
                                        ],
                                    ],
                                    [
                                        "label" => "Multilevel",
                                        "url" => "#",
                                        "icon" => "table",
                                        "items" => [
                                            [
                                                "label" => "Second level 1",
                                                "url" => "#",
                                            ],
                                            [
                                                "label" => "Second level 2",
                                                "url" => "#",
                                                "items" => [
                                                    [
                                                        "label" => "Third level 1",
                                                        "url" => "#",
                                                    ],
                                                    [
                                                        "label" => "Third level 2",
                                                        "url" => "#",
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ]
                        )
                        ?>
                    </div>

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons-->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <?= Html::a(
                        '<span class="glyphicon glyphicon-off" aria-hidden="true"></span>',
                        ['/auth/default/logout'],
                        [
                            'data-method' => 'post',
                            'data-confirm' => \yii\helpers\Json::encode([
                                'isHTML' => false,
                                'type' => 'warning',
                                'confirmButtonColor' => '#DD6B55',
                                'confirmButtonText' => Yii::t('miranda', 'Yes, Log Out'),
                                'cancelButtonText' => Yii::t('miranda', 'Do Nothing'),
                                'title' => Yii::t('miranda', 'Are you sure you want to log out?'),
                            ]),
                        ]
                    )?>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">

            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">

                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                               aria-expanded="false">
                                <img src="<?= $avatar ?>" alt=""><?= Yii::$app->user->identity->profile->fullName ?>
                                <i class=" fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li>
                                    <?= Html::a('<i class="fa fa-user pull-right"></i> '. Yii::t('miranda','My Account'), ['/auth/default/profile']) ?>
                                </li>
                               <!-- <li>
                                    <a href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">Help</a>
                                </li>-->
                                <li>
                                    <?= Html::a(
                                        'Log Out ',
                                        ['/auth/default/logout'],
                                        [
                                            'data-method' => 'post',
                                            'data-confirm' => \yii\helpers\Json::encode([
                                                'isHTML' => false,
                                                'type' => 'warning',
                                                'confirmButtonColor' => '#DD6B55',
                                                'confirmButtonText' => Yii::t('miranda', 'Yes, Log Out'),
                                                'cancelButtonText' => Yii::t('miranda', 'Do Nothing'),
                                                'title' => Yii::t('miranda', 'Are you sure you want to log out?'),
                                            ]),
                                        ]
                                    )?>
                                </li>
                            </ul>
                        </li>

                        <li class="">

                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fa fa-language" aria-hidden="true"></i>
                                <?= Yii::$app->params['languages'][Yii::$app->language] ?>
                                <i class=" fa fa-angle-down"></i>
                            </a>

                            <?= \backend\widgets\LanguageSelector\LanguageSelector::widget(); ?>

                        </li>

                       <!-- <li role="presentation" class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge bg-green">6</span>
                            </a>
                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                <li>
                                    <a>
                      <span class="image">
                                        <img src="http://placehold.it/128x128" alt="Profile Image"/>
                                    </span>
                      <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                      <span class="image">
                                        <img src="http://placehold.it/128x128" alt="Profile Image"/>
                                    </span>
                      <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                      <span class="image">
                                        <img src="http://placehold.it/128x128" alt="Profile Image"/>
                                    </span>
                      <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                      <span class="image">
                                        <img src="http://placehold.it/128x128" alt="Profile Image"/>
                                    </span>
                      <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                                    </a>
                                </li>
                                <li>
                                    <div class="text-center">
                                        <a href="/">
                                            <strong>See All Alerts</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>-->


                    </ul>
                </nav>
            </div>

        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">

                <!--<div class="page-title">
                    <div class="title_left">
                        <h1>Test</h1>
                    </div>
                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>-->

            <div class="clearfix"></div>

            <?= \yii\widgets\Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]) ?>

            <?= $content ?>

            <br>
        </div>
        <!-- /page content -->
        <!-- footer content -->
        <footer>
            <div class="pull-right">
                <?= \common\components\Miranda::poweredBlock() ?>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
<!-- /footer content -->
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>

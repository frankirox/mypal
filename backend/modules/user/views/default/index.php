<?php

use backend\grid\GridPageSize;
use backend\grid\GridQuickLinks;
use backend\grid\GridView;
use common\helpers\Html;
use common\models\Role;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\UserSearch $searchModel
 */
$this->title = Yii::t('miranda/user', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="row">
        <div class="col-sm-8">
            <h3><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="col-sm-4 text-right">
            <?= Html::a(Yii::t('miranda', 'Add New'), ['/user/default/create'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-6">
                    <?= GridQuickLinks::widget([
                        'model' => User::className(),
                        'searchModel' => $searchModel,
                    ]) ?>
                </div>

                <div class="col-sm-6 text-right">
                    <?= GridPageSize::widget(['pjaxId' => 'user-grid-pjax']) ?>
                </div>
            </div>

            <hr>
            
            <?php
            Pjax::begin([
                'id' => 'user-grid-pjax',
            ])
            ?>

            <?= GridView::widget([
                'id' => 'user-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'bulkActions' => true,
                'bulkActionOptions' => [
                    'gridId' => 'user-grid',
                ],
                'columns' => [
                    ['class' => 'backend\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                    [
                        'attribute' => 'username',
                        'controller' => '/user/default',
                        'class' => 'backend\grid\columns\TitleActionColumn',
                        'title' => function (User $model) {
                            if (User::hasPermission('editUsers')) {
                                return Html::a($model->username, ['/user/default/update', 'id' => $model->id], ['data-pjax' => 0]);
                            } else {
                                return $model->username;
                            }
                        },
                        'buttonOptions' => [
                            'class'   => 'btn btn-xs btn-default',
                        ],
                        'buttonsTemplate' => '{update} {delete} {permissions} {password}',
                        'buttons' => [
                            'permissions' => function ($url, $model, $key) {

                                if($model->superadmin){

                                    return null;
                                }

                                return Html::a(Yii::t('miranda/user', 'Permissions'),
                                    Url::to(['user-permission/set', 'id' => $model->id]), [
                                        'title' => Yii::t('miranda/user', 'Permissions'),
                                        'class'   => 'btn btn-xs btn-default',
                                        'data-pjax' => '0'
                                    ]
                                );
                            },
                            'password' => function ($url, $model, $key) {
                                return Html::a(Yii::t('miranda/user', 'Password'),
                                    Url::to(['default/change-password', 'id' => $model->id]), [
                                        'title' => Yii::t('miranda/user', 'Password'),
                                        'class'   => 'btn btn-xs btn-default',
                                        'data-pjax' => '0'
                                    ]
                                );
                            }
                        ],
                        'options' => ['style' => 'width:300px']
                    ],
                    [
                        'attribute' => 'email',
                        'format' => 'raw',
                        'visible' => User::hasPermission('viewUserEmail'),
                    ],
                    /* [
                      'class' => 'backend\grid\columns\StatusColumn',
                      'attribute' => 'email_confirmed',
                      'visible' => User::hasPermission('viewUserEmail'),
                      ], */
                    [
                        'attribute' => 'gridRoleSearch',
                        'filter' => ArrayHelper::map(Role::getAvailableRoles(Yii::$app->user->isSuperAdmin),
                            'name', 'description'),
                        'value' => function (User $model) {

                            if($model->superadmin){

                                return Yii::t('miranda', 'All');
                            }

                            return implode(', ', ArrayHelper::map(Role::getUserRoles($model->id),'name', function($model){
                                return ucfirst($model->name);
                            }));
                        },
                        'format' => 'raw',
                        'visible' => User::hasPermission('viewUserRoles'),
                    ],
                    [
                        'class' => 'backend\grid\columns\StatusColumn',
                        'attribute' => 'superadmin',
                        'optionsArray' => [
                            [false, Yii::t('miranda', 'No'), 'default'],
                            [true, Yii::t('miranda', 'Yes'), 'info'],
                        ],
                        'options' => ['style' => 'width:60px']
                    ],
                    [
                        'class' => 'backend\grid\columns\StatusColumn',
                        'attribute' => 'status',
                        'optionsArray' => [
                            [User::STATUS_ACTIVE, Yii::t('miranda', 'Active'), 'primary'],
                            [User::STATUS_INACTIVE, Yii::t('miranda', 'Inactive'), 'info'],
                            [User::STATUS_BANNED, Yii::t('miranda', 'Banned'), 'default'],
                        ],
                        'options' => ['style' => 'width:60px']
                    ],
                ],
            ]);
            ?>

            <?php Pjax::end() ?>

        </div>
    </div>
</div>

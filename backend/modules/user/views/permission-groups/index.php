<?php

use backend\grid\GridPageSize;
use backend\grid\GridView;
use common\helpers\Html;
use common\models\User;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\user\models\search\AuthItemGroupSearch $searchModel
 */
$this->title = Yii::t('miranda/user', 'Permission Groups');
$this->params['breadcrumbs'][] = ['label' => Yii::t('miranda/user', 'Users'), 'url' => ['/user/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="permission-groups-index">

    <div class="row">
        <div class="col-sm-8">
            <h3><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="col-sm-4 text-right">
            <?= Html::a(Yii::t('miranda', 'Add New'), ['create'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-12 text-right">
                    <?= GridPageSize::widget(['pjaxId' => 'permission-groups-grid-pjax']) ?>
                </div>
            </div>

            <hr>

            <?php
            Pjax::begin([
                'id' => 'permission-groups-grid-pjax',
            ])
            ?>

            <?=
            GridView::widget([
                'id' => 'permission-groups-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'bulkActions' => true,
                'bulkActionOptions' => [
                    'gridId' => 'permission-grid',
                    'actions' => [Url::to(['bulk-delete']) => Yii::t('miranda', 'Delete')]
                ],
                'columns' => [
                    ['class' => 'backend\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                    [
                        'attribute' => 'name',
                        'class' => 'backend\grid\columns\TitleActionColumn',
                        'controller' => '/user/permission-groups',
                        'title' => function ($model) {
                            if (User::hasPermission('manageRolesAndPermissions')) {
                                return Html::a(
                                    $model->name, ['update', 'id' => $model->code],
                                    ['data-pjax' => 0]
                                );
                            } else {
                                return $model->name;
                            }

                        },
                        'buttonOptions' => [
                            'class' => 'btn btn-xs btn-default',
                        ],
                        'buttonsTemplate' => '{update} {delete}',
                    ],
                    'code',
                ],
            ]);
            ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>


































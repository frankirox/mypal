<?php

use backend\grid\GridPageSize;
use backend\grid\GridQuickLinks;
use kartik\grid\GridView;
use common\helpers\Html;
use common\models\User;
use common\models\Pet;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('miranda/post', 'Pets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <div class="row">
        <div class="col-sm-8">
            <h3><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="col-sm-4 text-right">
            <?= Html::a(Yii::t('miranda', 'Add New'), ['/pet/default/create'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-6">
                    <?= GridQuickLinks::widget([
                        'model' => Pet::className(),
                        'searchModel' => $searchModel,
                        'labels' => [
                            'all' => Yii::t('miranda', 'All'),
                            'active' => Yii::t('miranda', 'Sold'),
                            'inactive' => Yii::t('miranda', 'Not Sold'),
                        ]
                    ]) ?>
                </div>

                <div class="col-sm-6 text-right">
                    <?= GridPageSize::widget(['pjaxId' => 'pet-grid-pjax']) ?>
                </div>
            </div>

            <hr>

            <?php
            Pjax::begin([
                'id' => 'pet-grid-pjax',
            ])
            ?>

            <?=
            GridView::widget([
                'id' => 'pet-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'striped' => true,
                'bordered' => true,
                'condensed' => true,
                'hover' => true,
                'tableOptions' => ['class' => 'table dataTable'],
                'rowOptions' => ['class' => 'tr-v-align-middle '],
                'columns' => [

                    [
                        'attribute' => 'breed',
                        'value' => 'breed',
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'age',
                        'value' => 'age',
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'name',
                        'value' => 'name',
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'sold_at',
                        'value' => 'sold_at',
                        'filterType' => GridView::FILTER_DATE_RANGE,
                        'filterWidgetOptions' => ([
                            'attribute' => 'sold_at',
                            'presetDropdown' => true,
                            'convertFormat' => true,
                            'pluginOptions' => [
                                'locale' => ['format' => 'Y-m-d'],
                            ],
                        ]),
                        'format' => 'raw',
                        'noWrap' => true,

                    ],
                    [
                        'attribute' => 'created_at',
                        'value' => 'created_at',
                        'filterType' => GridView::FILTER_DATE_RANGE,
                        'filterWidgetOptions' => ([
                            'attribute' => 'created_at',
                            'presetDropdown' => true,
                            'convertFormat' => true,
                            'pluginOptions' => [
                                'locale' => ['format' => 'Y-m-d'],
                            ],
                        ]),
                        'format' => 'raw',
                        'noWrap' => true,

                    ],
                    [
                        'attribute' => 'created_by',
                        'filter' => common\models\User::getUsersList(),
                        'value' => function (Pet $model) {
                            return $model->createdBy->username;
                        },
                        'format' => 'raw',
                        'options' => ['style' => 'width:180px'],
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template' => '{update} {delete}',
                        'mergeHeader' => false,
                        'noWrap' => true,
                        'buttons' => [
                            'update' => function ($url, $model) {

                                if (Yii::$app->user->identity->hasPermission('editPets')) {

                                    return Html::a('<div class="btn btn-sm btn-default"><i style="font-size:18px" class="fa fa-edit"></i></div>',
                                        $url, [
                                            'title' => Yii::t('miranda/pets', 'Update {pet}',
                                                ['pet' => "{$model->breed} {$model->name}"]),
                                            'class' => 'no-pjax',
                                        ]);
                                }

                                return null;

                            },
                            'delete' => function ($url, $model) {

                                if (Yii::$app->user->identity->hasPermission('deletePets')) {

                                    return Html::a('<div class="btn btn-sm btn-default"><i style="font-size:18px" class="fa fa-trash-o"></i></div>',
                                        $url, [
                                            'title' => Yii::t('miranda/pets', 'Delete {pet}',
                                                ['pet' => "{$model->breed} {$model->name}"]),
                                            'class' => 'no-pjax',
                                            'data-method' => 'post',
                                            'data-confirm' => Yii::t(
                                                'yii',
                                                'Are you sure you want to delete this item?'
                                            ),
                                        ]);
                                }

                                return null;
                            }
                        ]

                    ],
                ],
            ]);
            ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>
<?php

use backend\grid\GridPageSize;
use backend\grid\GridView;
use common\helpers\Html;
use common\models\Role;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\RoleSearch $searchModel
 * @var yii\web\View $this
 */
$this->title = Yii::t('miranda/user', 'Roles');
$this->params['breadcrumbs'][] = ['label' => Yii::t('miranda/user', 'Users'), 'url' => ['/user/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="role-index">

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
                    <?= GridPageSize::widget(['pjaxId' => 'role-grid-pjax']) ?>
                </div>
            </div>

            <hr>

            <?php Pjax::begin(['id' => 'role-grid-pjax']) ?>

            <?=
            GridView::widget([
                'id' => 'role-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'bulkActions' => true,
                'bulkActionOptions' => [
                    'gridId' => 'role-grid',
                    'actions' => [Url::to(['bulk-delete']) => Yii::t('miranda', 'Delete')]
                ],
                'columns' => [
                    ['class' => 'backend\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                    [
                        'attribute' => 'description',
                        'class' => 'backend\grid\columns\TitleActionColumn',
                        'controller' => '/user/role',
                        'title' => function (Role $model) {
                            return Html::a($model->description,
                                ['view', 'id' => $model->name],
                                ['data-pjax' => 0]);
                        },
                        'buttonOptions' => [
                            'class' => 'btn btn-xs btn-default',
                        ],
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                $options = array_merge([
                                    'title' => Yii::t('miranda', 'Settings'),
                                    'aria-label' => Yii::t('miranda', 'Settings'),
                                    'class' => 'btn btn-xs btn-default',
                                    'data-pjax' => '0',
                                ]);
                                return Html::a(Yii::t('miranda', 'Settings'), $url, $options);
                            }
                        ],
                    ],
                    [
                        'attribute' => 'name',
                        'options' => ['style' => 'width:200px'],
                    ],
                ],
            ]);
            ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>





















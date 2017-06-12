<?php

namespace backend\grid;

use backend\grid\GridViewAsset;
use yii\helpers\Html;

class GridView extends \kartik\grid\GridView
{

    public $striped = true;
    public $bordered = true;
    public $condensed = true;
    public $hover = true;

    public $dataColumnClass = 'backend\grid\columns\DataColumn';

    public $tableOptions = ['class' => 'table dataTable'];

    public $rowOptions = ['class' => 'tr-v-align-middle '];


    public $bulkActions = false;
    public $bulkActionOptions = [];
    public $filterPosition = self::FILTER_POS_HEADER;

    /* public $pager = [
         'options' => ['class' => 'pagination pagination-sm'],
         'hideOnSinglePage' => true,
         'firstPageLabel' => '<<',
         'prevPageLabel' => '<',
         'nextPageLabel' => '>',
         'lastPageLabel' => '>>',
     ];*/
    //public $tableOptions = ['class' => 'table table-striped'];

    public $layout = '{items}<div class="row"><div class="col-sm-4 m-tb-20">{bulkActions}</div><div class="col-sm-5 text-center">{pager}</div><div class="col-sm-3 text-right m-tb-20">{summary}</div></div>';


    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->bordered) {
            Html::addCssClass($this->tableOptions, 'table-bordered');
        }
        if ($this->condensed) {
            Html::addCssClass($this->tableOptions, 'table-condensed');
        }
        if ($this->striped) {
            Html::addCssClass($this->tableOptions, 'table-striped');
        }
        if ($this->hover) {
            Html::addCssClass($this->tableOptions, 'table-hover');
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        //GridViewAsset::register($this->view);
        parent::run();
    }

    /**
     * @inheritdoc
     */
    public function renderPager()
    {
        return Html::tag('div', parent::renderPager(), ['class' => 'dataTables_paginate paging_simple_numbers']);
    }

    public function renderSection($name)
    {
        switch ($name) {
            case '{bulkActions}':
                return $this->renderBulkActions();
            default:
                return parent::renderSection($name);
        }
    }

    public function renderBulkActions()
    {
        if ($this->bulkActions === true) {
            $this->bulkActions = GridBulkActions::widget($this->bulkActionOptions);
        } else {
            $this->bulkActions = '';
        }
        return $this->bulkActions;
    }
}

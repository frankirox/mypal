<?php

namespace backend\grid;

use common\helpers\Html;
use Closure;
use kartik\checkbox\CheckboxX;

class CheckboxColumn extends \kartik\grid\CheckboxColumn
{


    public $rowSelectedClass = 'success';

    /**
     * Renders the header cell content.
     * The default implementation simply renders [[header]].
     * This method may be overridden to customize the rendering of the header cell.
     * @return string the rendering result
     */
    /* protected function renderHeaderCellContent()
     {
         return CheckboxX::widget([
             'name'=> $this->name,
             'options'=> ['class' => 'select-on-check-all'],
             'pluginOptions'=>['threeState'=>false]
         ]);

     }*/

    /**
     * @inheritdoc
     */
    /* protected function renderDataCellContent($model, $key, $index)
     {
         return CheckboxX::widget([
             'name'=> $this->name,
             'options'=> $this->checkboxOptions,
             'pluginOptions'=>['threeState'=>false]
         ]);
     }*/

}

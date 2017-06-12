<?php

namespace common\models\query;

use common\models\traits\MultilingualTrait;


class TicketDepartmentQuery extends \yii\db\ActiveQuery
{

    use MultilingualTrait;

    public function all($db = null)
    {
        return parent::all($db);
    }


    public function one($db = null)
    {
        return parent::one($db);
    }

}

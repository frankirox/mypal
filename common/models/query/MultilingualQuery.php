<?php

namespace common\models\query;

use common\models\traits\MultilingualTrait;
use yii\db\ActiveQuery;

class MultilingualQuery extends ActiveQuery
{
    use MultilingualTrait;
}
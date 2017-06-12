<?php

namespace common\models\query;

use common\models\traits\MultilingualTrait;
use paulzi\nestedintervals\NestedIntervalsQueryTrait;


/**
 * This is the ActiveQuery class for [[Post]].
 *
 * @see Pet
 */
class PostCategoryQuery extends \yii\db\ActiveQuery
{

    use MultilingualTrait;
    use NestedIntervalsQueryTrait;


    /**
     * @inheritdoc
     * @return Post[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Post|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}

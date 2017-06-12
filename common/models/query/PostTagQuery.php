<?php

namespace common\models\query;

use common\models\traits\MultilingualTrait;

/**
 * This is the ActiveQuery class for [[Tag]].
 *
 * @see Pet
 */
class PostTagQuery extends \yii\db\ActiveQuery
{

    use MultilingualTrait;

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

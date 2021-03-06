<?php

namespace common\models\query;

use common\db\ActiveQuery;
use common\models\Block;
use common\models\traits\MultilingualTrait;

/**
 * This is the ActiveQuery class for [[Block]].
 *
 * @see Block
 */
class BlockQuery extends ActiveQuery
{

    use MultilingualTrait;

    /**
     *
     * @inheritdoc
     * @return Block[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Block|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}

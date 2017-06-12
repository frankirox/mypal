<?php

namespace common\models\query;

use common\models\Pet;
use common\models\traits\MultilingualTrait;

/**
 * This is the ActiveQuery class for [[Post]].
 *
 * @see Pet
 */
class PostQuery extends \yii\db\ActiveQuery
{

    public function notSold()
    {
        $this->andWhere(['sold_at IS NULL']);
        return $this;
    }


    public function sold()
    {
        $this->andWhere(['sold_at IS NOT NULL']);
        return $this;
    }

    /**
     * @inheritdoc
     * @return Pet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Pet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}

<?php

namespace common\models\query;

use common\db\ActiveQuery;
use common\models\Carousel;


/**
 * This is the ActiveQuery class for [[Block]].
 *
 * @see Block
 */
class CarouselQuery extends ActiveQuery
{

    /**
     * @inheritdoc
     * @return Carousel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Carousel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}

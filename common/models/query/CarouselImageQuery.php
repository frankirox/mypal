<?php

namespace common\models\query;

use common\db\ActiveQuery;
use common\models\Carousel;
use common\models\CarouselImage;
use common\models\traits\MultilingualTrait;


/**
 * This is the ActiveQuery class for [[Block]].
 *
 * @see Block
 */
class CarouselImageQuery extends ActiveQuery
{

    use MultilingualTrait;

    public function active()
    {
        $this->andWhere(['status' =>  CarouselImage::STATUS_ON]);
        return $this;
    }

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

<?php

namespace backend\widgets;//common\widgets\dashboard;

use common\widgets\DashboardWidget;

class Info extends DashboardWidget
{
    public function run()
    {
        return $this->render('info',
            [
                'height' => $this->height,
                'width' => $this->width,
                'position' => $this->position,
            ]);
    }
}
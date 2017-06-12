<?php
/**
 * @link http://www.webmized.com/
 * @copyright Copyright (c) 2015 Franchesco Fonseca
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace backend\modules\pet;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Pet Module For Miranda CMS
 *
 * @author Franchesco Fonseca <fonseca.franchesco@gmail.com>
 */
class PetModule extends \yii\base\Module
{
    /**
     * Version number of the module.
     */
    const VERSION = '0.1.0';

    public $controllerNamespace = 'backend\modules\pet\controllers';

    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }
}
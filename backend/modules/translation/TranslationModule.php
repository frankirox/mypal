<?php
/**
 * @link http://www.webmized.com/
 * @copyright Copyright (c) 2015 Franchesco Fonseca
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */


namespace backend\modules\translation;

/**
 * Translation Module For Miranda CMS
 *
 * @author Frachesco Fonseca <fonseca.franchesco@gmail.com>
 */
class TranslationModule extends \yii\base\Module
{
    /**
     * Version number of the module.
     */
    const VERSION = '0.1.0';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\translation\controllers'; //'common\translation\controllers';

}
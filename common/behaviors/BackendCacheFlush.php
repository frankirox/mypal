<?php
namespace common\behaviors;

use common\helpers\MirandaHelper;
use Yii;
use yii\db\ActiveRecord;

/**
 * BackendCacheFlush behavior
 * @package yii\easyii\behaviors
 * @inheritdoc
 */
class BackendCacheFlush extends \yii\base\Behavior
{

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'flush',
            ActiveRecord::EVENT_AFTER_UPDATE => 'flush',
            ActiveRecord::EVENT_AFTER_DELETE => 'flush',
        ];
    }

    /**
     * Flush cache
     */
    public function flush()
    {

        $backendAssetPath = Yii::getAlias('@backend') . '/web/assets/';
        $backendRuntimeCachePath = Yii::getAlias('@backend') . '/runtime/cache/';

        @MirandaHelper::recursiveDelete($backendAssetPath);
        @MirandaHelper::recursiveDelete($backendRuntimeCachePath);


        if (!is_dir($backendAssetPath)) {
            @mkdir($backendAssetPath);
            @chmod("$backendAssetPath", 0777);
        }


        if (!is_dir($backendRuntimeCachePath)) {
            @mkdir($backendRuntimeCachePath);
            @chmod("$backendRuntimeCachePath", 0777);
        }

        Yii::$app->cache->flush();
        Yii::$app->db->schema->refresh();

    }

}
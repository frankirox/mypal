<?php

namespace common\behaviors;

use common\helpers\MirandaHelper;
use Yii;
use yii\db\ActiveRecord;

/**
 * FrontendCacheFlush behavior
 * @package yii\easyii\behaviors
 * @inheritdoc
 */
class FrontendCacheFlush extends \yii\base\Behavior
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

        $frontendAssetPath = Yii::getAlias('@frontend') . '/web/assets/';
        $frontendRuntimeCachePath = Yii::getAlias('@frontend') . '/runtime/cache/';

        @MirandaHelper::recursiveDelete($frontendAssetPath);
        @MirandaHelper::recursiveDelete($frontendRuntimeCachePath);

        if (!is_dir($frontendAssetPath)) {
            @mkdir($frontendAssetPath);
            @chmod("$frontendAssetPath", 0777);
        }

        if (!is_dir($frontendRuntimeCachePath)) {
            @mkdir($frontendRuntimeCachePath);
            @chmod("$frontendRuntimeCachePath", 0777);
        }

        Yii::$app->cache->flush();
        Yii::$app->db->schema->refresh();

    }

}
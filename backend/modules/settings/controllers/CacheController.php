<?php

namespace backend\modules\settings\controllers;

use backend\controllers\BaseController;
use common\helpers\MirandaHelper;
use Yii;

/**
 * CacheController implements Flush Cache page.
 *
 * @author Franchesco Fonseca <fonseca.franchesco@gmail.com>
 */
class CacheController extends BaseController
{
    /**
     * @inheritdoc
     */
    public $enableOnlyActions = ['flush'];

    public function actionFlush()
    {
        $frontendAssetPath = Yii::getAlias('@frontend') . '/web/assets/';
        $backendAssetPath = Yii::getAlias('@backend') . '/web/assets/';

        $consoleRuntimeCachePath = Yii::getAlias('@console') . '/runtime/cache/';
        $frontendRuntimeCachePath = Yii::getAlias('@frontend') . '/runtime/cache/';
        $backendRuntimeCachePath = Yii::getAlias('@backend') . '/runtime/cache/';

        @MirandaHelper::recursiveDelete($frontendAssetPath);
        @MirandaHelper::recursiveDelete($backendAssetPath);

        @MirandaHelper::recursiveDelete($consoleRuntimeCachePath);
        @MirandaHelper::recursiveDelete($frontendRuntimeCachePath);
        @MirandaHelper::recursiveDelete($backendRuntimeCachePath);

        if (!is_dir($frontendAssetPath)) {
            @mkdir($frontendAssetPath);
            @chmod("$frontendAssetPath", 0777);
        }

        if (!is_dir($backendAssetPath)) {
            @mkdir($backendAssetPath);
            @chmod("$frontendAssetPath", 0777);
        }


        if (!is_dir($frontendRuntimeCachePath)) {
            @mkdir($frontendRuntimeCachePath);
            @chmod("$frontendRuntimeCachePath", 0777);
        }

        if (!is_dir($backendRuntimeCachePath)) {
            @mkdir($backendRuntimeCachePath);
            @chmod("$backendRuntimeCachePath", 0777);
        }

        //Yii::$app->session->removeAll()

        if (Yii::$app->cache->flush() && Yii::$app->db->schema->refresh()) {
            Yii::$app->session->setFlash('crudMessage', 'Cache has been flushed.');
        } else {
            Yii::$app->session->setFlash('crudMessage', 'Failed to flush cache.');
        }

        return Yii::$app->getResponse()->redirect(Yii::$app->getRequest()->referrer);
    }
}
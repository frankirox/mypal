<?php

namespace common\widgets\ProfilePicture\actions;

use Yii;
use yii\base\Action;
use yii\base\Exception;
use yii\base\UserException;
use common\widgets\ProfilePicture\helpers\SimpleImage;
use common\widgets\ProfilePicture\helpers\BMP;
use common\widgets\ProfilePicture\helpers\ImageTools;

class ProfilePictureSaveAction extends ProfilePictureBaseAction
{

    public function run($id)
    {
        $tmp_file = Yii::$app->session->get('_tmp_img');
        $new_file = str_replace('tmp_img_', '', $tmp_file);

        ImageTools::crop_image($this->upload_path . DIRECTORY_SEPARATOR . $new_file,
            $this->upload_path . DIRECTORY_SEPARATOR . $tmp_file, $_POST['w'], $_POST['h'], $_POST['x1'], $_POST['y1'],
            $this->crop_width / $_POST['w']);

        @unlink($this->upload_path . DIRECTORY_SEPARATOR . $tmp_file);
        Yii::$app->session->remove('_tmp_img');

        $model = new $this->targetClassName;
        $model = $model::find()->where(['id' => $id])->one();

        if ($model instanceof $this->targetClassName) {
            $model->updateAttributes([$this->targetAttributeName => $new_file]);
        }

        $this->json_success($this->upload_path_url . '/' . $new_file . '?' . time());

    }
}
<?php

namespace common\widgets\ProfilePicture\actions;

use Yii;
use yii\base\Action;
use yii\base\Exception;
use yii\base\UserException;
use common\widgets\ProfilePicture\helpers\SimpleImage;
use common\widgets\ProfilePicture\helpers\BMP;
use common\widgets\ProfilePicture\helpers\ImageTools;

class ProfilePictureWebcamAction extends ProfilePictureBaseAction
{

    public function run()
    {

        $data = file_get_contents($_FILES['webcam']['tmp_name']);
        $path = $this->upload_path;
        if (!empty($data)) {
            $file = 'tmp_img_' . $this->filename . '.jpg';
            if (file_put_contents($path . DIRECTORY_SEPARATOR . $file, $data)) {
                Yii::$app->session->set('_tmp_img', $file);
                echo $this->upload_path_url . '/' . $file . '?' . time();
            } else {
                echo '0';
            }
        } else {
            echo '0';
        }
    }
}
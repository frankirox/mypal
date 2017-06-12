<?php

namespace  common\widgets\ProfilePicture\actions;

use Yii;
use yii\base\Action;
use yii\base\Exception;
use yii\base\UserException;
use common\widgets\ProfilePicture\helpers\SimpleImage;
use common\widgets\ProfilePicture\helpers\BMP;
use common\widgets\ProfilePicture\helpers\ImageTools;

class ProfilePictureUploadAction extends ProfilePictureBaseAction
{

    public function run()
    {

        if (isset($_FILES['ajax-uploadimage']['tmp_name'])) {
            //Get uploaded image
            $image = $_FILES['ajax-uploadimage'];

            //Get php.ini upload limit
            $max_post = (int)(ini_get('post_max_size'));
            $max_upload = (int)(ini_get('upload_max_filesize'));
            $memory_limit = (int)(ini_get('memory_limit'));
            $upload_limit = min($max_upload, $max_post, $memory_limit);
            
            $errors = array(
                0 => "The file is to big. Upload a image under $upload_limit",
                1 => 'This file extension is not allowed !',
                2 => "The image size is to small. The image must be at least $this->min_width x $this->min_height."
            );

            //Get image extension
            $ext = $this->get_file_ext($image['name']);

            if (!is_uploaded_file($image['tmp_name'])) {
                return false;
            } else {
                if ($image['size'] > $upload_limit * 100 * 100 * 100) {
                    $this->json_error($errors[0]);
                } else {

                    if (!in_array($ext, $this->allowed_extensions)) {
                        $this->json_error($errors[1]);
                    } else {

                        $ext = '.' . $ext;
                        $this->filename = 'tmp_img_' . $this->filename;

                        $file = $this->upload_path . DIRECTORY_SEPARATOR  . $this->filename . $ext;
                        if (move_uploaded_file($image['tmp_name'], $file)) {

                            $image = new SimpleImage();
                            $image->load($file);
                            if ($image->getWidth() > $this->max_width) {
                                $image->resizeToWidth($this->max_width);
                                $image->save($file);
                            }

                            $image = new SimpleImage();
                            $image->load($file);
                            if ($image->getHeight() > $this->max_height) {
                                $image->resizeToHeight($this->max_height);
                                $image->save($file);
                            }

                            $image = new SimpleImage();
                            $image->load($file);

                            if ($image->getWidth() < $this->min_width || $image->getHeight() < $this->min_height) {
                                $this->json_error($errors[2]);
                                @unlink(v);
                            } else {
                                Yii::$app->session->set('_tmp_img', $this->filename . $ext);
                                $this->json_success($this->upload_path_url . '/' . $this->filename . $ext . '?' . time());
                            }
                        }
                    }
                }
            }
        } else {
            $this->json_error();
        }

    }
}
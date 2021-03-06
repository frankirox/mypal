<?php

namespace common\widgets\ProfilePicture\actions;

use Yii;
use yii\base\Action;
use yii\base\Exception;
use yii\base\UserException;
use common\widgets\ProfilePicture\helpers\SimpleImage;
use common\widgets\ProfilePicture\helpers\BMP;
use common\widgets\ProfilePicture\helpers\ImageTools;

abstract class ProfilePictureBaseAction extends Action
{
    public $targetClassName;
    public $targetAttributeName;
    public $max_width = 500;
    public $max_height = 500;
    public $min_width = 200;
    public $min_height = 200;
    public $crop_width = 200;
    public $allowed_extensions = ['jpg', 'png', 'jpeg', 'gif', 'bmp'];
    public $upload_path = null;
    public $upload_path_url = null;
    protected $filename;

    public function init()
    {
        $this->filename = Yii::$app->security->generateRandomString() . time();

        parent::init(); // TODO: Change the autogenerated stub
    }

    function get_url()
    {
        $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        return
            ($https ? 'https://' : 'http://') .
            (!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'] . '@' : '') .
            (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'] .
                ($https && $_SERVER['SERVER_PORT'] === 443 ||
                $_SERVER['SERVER_PORT'] === 80 ? '' : ':' . $_SERVER['SERVER_PORT']))) .
            substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
    }

    protected function get_file_ext($file)
    {
        $ext = strtolower($file[strlen($file) - 4] . $file[strlen($file) - 3] . $file[strlen($file) - 2] . $file[strlen($file) - 1]);
        if ($ext[0] == '.') {
            $ext = substr($ext, 1, 3);
        }
        return $ext;
    }

    protected function json_success($data = array())
    {
        echo json_encode(array('success' => true, 'data' => $data));
    }

    protected function json_error($data = array())
    {
        echo json_encode(array('success' => false, 'data' => $data));
    }
}
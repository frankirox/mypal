<?php
session_start();
//Here you may check if the user is logged

//Image filename. You can specify the name of the file. You can set this to a user id or something
$filename = substr(md5($_SERVER['REMOTE_ADDR']), 0, 10);

define('IMG_MAX_WIDTH', 500); //Image max width (in pixels)
define('IMG_MAX_HEIGHT', 500); //Image max height (in pixels)
define('IMG_MIN_WIDTH', 200); //Image min width (in pixels)
define('IMG_MIN_HEIGHT', 200); //Image min height (in pixels)
define('IMG_CROP_WIDTH', 200); //Image crop width (in pixels)

define('ALLOWED_IMAGES', 'jpg|png|jpeg|gif|bmp'); //Allowed extensions
define('UPLOAD_PATH', '../files/');               //Upload path

//Callback function
function save_image_cb($image)
{
    //You can save the image to database
}

require_once(dirname(__FILE__) . '/SimpleImage.php');

if (empty($_REQUEST['action'])) {
    $_POST['action'] = 'webcam';
}

if (isset($_POST['action'])) {
    switch ($_POST['action']) {

        //Upload
        case 'upload':
            if (isset($_FILES['ajax-uploadimage']['tmp_name'])) {
                //Get uploaded image
                $image = $_FILES['ajax-uploadimage'];

                //Get php.ini upload limit
                $max_post = (int)(ini_get('post_max_size'));
                $max_upload = (int)(ini_get('upload_max_filesize'));
                $memory_limit = (int)(ini_get('memory_limit'));
                $upload_limit = min($max_upload, $max_post, $memory_limit);

                //Get some config options
                $max_width = IMG_MAX_WIDTH;
                $max_height = IMG_MAX_HEIGHT;
                $min_width = IMG_MIN_WIDTH;
                $min_height = IMG_MIN_HEIGHT;
                $allowed_img = ALLOWED_IMAGES;
                $path = UPLOAD_PATH;
                $errors = array(
                    0 => "The file is to big. Upload a image under $upload_limit",
                    1 => 'This file extension is not allowed !',
                    2 => "The image size is to small. The image must be at least $min_width x $min_height."
                );

                //Get image extension
                $ext = get_file_ext($image['name']);

                if (!is_uploaded_file($image['tmp_name'])) {
                    return false;
                } else {
                    if ($image['size'] > $upload_limit * 100 * 100 * 100) {
                        json_error($errors[0]);
                    } else {
                        if (!in_array($ext, explode('|', $allowed_img))) {
                            json_error($errors[1]);
                        } else {
                            $ext = '.' . $ext;
                            $filename = '-' . $filename;
                            if (!is_dir($path)) {
                                mkdir($path);
                            }

                            $path .= basename($filename . $ext);
                            if (move_uploaded_file($image['tmp_name'], $path)) {

                                $image = new SimpleImage();
                                $image->load($path);
                                if ($image->getWidth() > $max_width) {
                                    $image->resizeToWidth($max_width);
                                    $image->save($path);
                                }

                                $image = new SimpleImage();
                                $image->load($path);
                                if ($image->getHeight() > $max_height) {
                                    $image->resizeToHeight($max_height);
                                    $image->save($path);
                                }

                                $image = new SimpleImage();
                                $image->load($path);

                                if ($image->getWidth() < $min_width || $image->getHeight() < $min_height) {
                                    json_error($errors[2]);
                                    @unlink($path);
                                } else {
                                    $_SESSION['_tmp_img'] = $filename . $ext;
                                    json_success(get_url() . '/' . $path . '?' . time());
                                }
                            }
                        }
                    }
                }
            } else {
                json_error();
            }
            break;

        //Webcam upload
        case 'webcam':
            $data = file_get_contents('php://input');
            $path = UPLOAD_PATH;
            if (!empty($data)) {
                $file = '-' . $filename . '.jpg';
                if (file_put_contents($path . $file, $data)) {
                    $_SESSION['_tmp_img'] = $file;
                    echo get_url() . '/' . $path . $file . '?' . time();
                } else {
                    echo '0';
                }
            } else {
                echo '0';
            }
            break;

        //Save cropped image
        case 'save':
            $path = UPLOAD_PATH;
            $file = $_SESSION['_tmp_img'];
            $new_file = str_replace('-', '', $file);

            crop_image($path . $new_file, $path . $file, $_POST['w'], $_POST['h'], $_POST['x1'], $_POST['y1'],
                IMG_CROP_WIDTH / $_POST['w']);

            @unlink($path . $file);
            unset($_SESSION['_tmp_img']);

            save_image_cb($new_file);

            json_success(get_url() . '/' . $path . $new_file . '?' . time());
            break;
    }
}

//Functions
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

function get_file_ext($file)
{
    $ext = strtolower($file[strlen($file) - 4] . $file[strlen($file) - 3] . $file[strlen($file) - 2] . $file[strlen($file) - 1]);
    if ($ext[0] == '.') {
        $ext = substr($ext, 1, 3);
    }
    return $ext;
}

function json_success($data = array())
{
    echo json_encode(array('success' => true, 'data' => $data));
}

function json_error($data = array())
{
    echo json_encode(array('success' => false, 'data' => $data));
}

?>
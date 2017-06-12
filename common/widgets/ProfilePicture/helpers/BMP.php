<?php

namespace common\widgets\ProfilePicture\helpers;


/**
 * Created by PhpStorm.
 * User: Franchesco
 * Date: 29/10/2016
 * Time: 16:29
 */

class BMP
{
    public static function imagebmp($img, $filename = false)
    {
        return ImageTools::imagebmp($img, $filename);
    }

    public static function imagecreatefrombmp($filename)
    {
        return ImageTools::imagecreatefrombmp($filename);
    }
}
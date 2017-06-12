<?php

namespace common\widgets\ProfilePicture\helpers;

/**
 * Created by PhpStorm.
 * User: Franchesco
 * Date: 29/10/2016
 * Time: 16:29
 */

class ImageTools{

    static function imagebmp($img, $filename = false)
    {
        $wid = imagesx($img);
        $hei = imagesy($img);
        $wid_pad = str_pad('', $wid % 4, "\0");

        $size = 54 + ($wid + $wid_pad) * $hei;

        //prepare & save header
        $header['identifier'] = 'BM';
        $header['file_size'] = self::dword($size);
        $header['reserved'] = self::dword(0);
        $header['bitmap_data'] = self::dword(54);
        $header['header_size'] = self::dword(40);
        $header['width'] = self::dword($wid);
        $header['height'] = self::dword($hei);
        $header['planes'] = self::word(1);
        $header['bits_per_pixel'] = self::word(24);
        $header['compression'] = self::dword(0);
        $header['data_size'] = self::dword(0);
        $header['h_resolution'] = self::dword(0);
        $header['v_resolution'] = self::dword(0);
        $header['colors'] = self::dword(0);
        $header['important_colors'] = self::dword(0);

        if ($filename) {
            $f = fopen($filename, "wb");
            foreach ($header AS $h) {
                fwrite($f, $h);
            }

            //save pixels
            for ($y = $hei - 1; $y >= 0; $y--) {
                for ($x = 0; $x < $wid; $x++) {
                    $rgb = imagecolorat($img, $x, $y);
                    fwrite($f, self::byte3($rgb));
                }
                fwrite($f, $wid_pad);
            }
            fclose($f);
        } else {
            foreach ($header AS $h) {
                echo $h;
            }

            //save pixels
            for ($y = $hei - 1; $y >= 0; $y--) {
                for ($x = 0; $x < $wid; $x++) {
                    $rgb = imagecolorat($img, $x, $y);
                    echo self::byte3($rgb);
                }
                echo $wid_pad;
            }
        }

        return $img;
    }

    static function imagecreatefrombmp($filename)
    {
        $f = fopen($filename, "rb");

        //read header
        $header = fread($f, 54);
        $header = unpack('c2identifier/Vfile_size/Vreserved/Vbitmap_data/Vheader_size/' .
            'Vwidth/Vheight/vplanes/vbits_per_pixel/Vcompression/Vdata_size/' .
            'Vh_resolution/Vv_resolution/Vcolors/Vimportant_colors', $header);

        if ($header['identifier1'] != 66 or $header['identifier2'] != 77) {
            die('Not a valid bmp file');
        }

        if ($header['bits_per_pixel'] != 24) {
            die('Only 24bit BMP images are supported');
        }

        $wid2 = ceil((3 * $header['width']) / 4) * 4;

        $wid = $header['width'];
        $hei = $header['height'];

        $img = imagecreatetruecolor($header['width'], $header['height']);

        //read pixels
        for ($y = $hei - 1; $y >= 0; $y--) {
            $row = fread($f, $wid2);
            $pixels = str_split($row, 3);
            for ($x = 0; $x < $wid; $x++) {
                imagesetpixel($img, $x, $y, self::dwordize($pixels[$x]));
            }
        }
        fclose($f);

        return $img;
    }

    static function dwordize($str)
    {
        $a = ord($str[0]);
        $b = ord($str[1]);
        $c = ord($str[2]);
        return $c * 256 * 256 + $b * 256 + $a;
    }

    static function byte3($n)
    {
        return chr($n & 255) . chr(($n >> 8) & 255) . chr(($n >> 16) & 255);
    }

    static function dword($n)
    {
        return pack("V", $n);
    }

    static function word($n)
    {
        return pack("v", $n);
    }

    static function crop_image($save_path, $image_path, $width, $height, $start_width, $start_height, $scale)
    {
        list($imagewidth, $imageheight, $imageType) = getimagesize($image_path);
        $imageType = image_type_to_mime_type($imageType);

        $newImageWidth = ceil($width * $scale);
        $newImageHeight = ceil($height * $scale);
        $newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);

        switch ($imageType) {
            case "image/gif":
                $source = imagecreatefromgif($image_path);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                $source = imagecreatefromjpeg($image_path);
                break;
            case "image/png":
            case "image/x-png":
                $source = imagecreatefrompng($image_path);
                break;
        }

        imagecopyresampled($newImage, $source, 0, 0, $start_width, $start_height, $newImageWidth, $newImageHeight, $width,
            $height);

        switch ($imageType) {
            case "image/gif":
                imagegif($newImage, $save_path);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                imagejpeg($newImage, $save_path, 90);
                break;
            case "image/png":
            case "image/x-png":
                imagepng($newImage, $save_path);
                break;
        }
        chmod($save_path, 0777);
        return $save_path;
    }
}
<?php

class Captcha
{
    protected $code;
    protected $width = 160;
    protected $height = 50;
    protected $code_length = 4;

    function __construct()
    {
        $chars = '23456789abcdefghklmnprstuvwxyz';
        $captcha_code = '';
        for ($i = 0; $i < $this->code_length; $i++) {
            $captcha_code .= $chars[random_int(0, strlen($chars) - 1)];
        }
        $this->code = strtoupper($captcha_code);
    }

    function getCode()
    {
        return $this->code;
    }

    function rand_dark_color($image)
    {
        return imagecolorallocatealpha($image, random_int(0, 100), random_int(0, 100), random_int(0, 100), 1);
    }


    function rand_light_color($image)
    {
        return imagecolorallocatealpha($image, random_int(100, 255), random_int(100, 255), random_int(100, 255), 100);
    }

    function showImage()
    {
        //Image creation
        $image = imagecreatetruecolor($this->width, $this->height);
        $width = imagesx($image);
        $height = imagesy($image);
        $font = 'Mona-Sans-Bold.ttf';
        $font_file = $_SERVER['DOCUMENT_ROOT'] . '/shop/catalog/view/company_files/' . $font;
        $background = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image, 0, 0, $width, $height, $background);

        //Visual noise
        for ($i = 0; $i < 8; $i++) {
            imagefilledellipse($image, random_int(0, 180), random_int(0, 50), random_int(40, 100), random_int(40, 100), $this->rand_light_color($image));
            imageline($image, 0, rand(5, 45), 160, rand(5, 45), $this->rand_dark_color($image));
        }

        for ($i = 0; $i < 1000; $i++) {
            imagesetpixel($image, random_int(0, $this->width), random_int(15, $this->height - 15), $this->rand_dark_color($image));
        }

        //Add code image
        $x = 0;
        for ($i = 0; $i < $this->code_length; $i++) {
            $font_size = random_int(20, 25);
            $x += intval(($i + 1) * 13);
            imagettftext($image, $font_size, random_int(-25, 25), $x, intval(($height + $font_size) / 2), $this->rand_dark_color($image), $font_file, $this->code[$i]);
        }

        ob_start();
        imagepng($image);
        // Capture the output and clear the output buffer
        $imagedata = ob_get_clean();
        imagedestroy($image);

        return $imagedata;
    }
}
?>
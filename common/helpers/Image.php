<?php
/**
 * 
 * ibagou.com 图片处理类
 * 包括3种缩略 及 水印方法，参考kohana中的图片处理
 * ============================================================================
 * 版权所有: ibagou。
 * 网站地址: http://www.ibagou.com/
 * ----------------------------------------------------------------------------
 * 许可声明：
 * ============================================================================
 * Author: wsq(cboy868@163.com)
 * Date: 14-11-27 下午6:55
 */

namespace common\helpers;


class Image {

    const NONE    = 0x01;
    const WIDTH   = 0x02;
    const HEIGHT  = 0x03;
    const AUTO    = 0x04;
    const INVERSE = 0x05;
    const PRECISE = 0x06;

    const HORIZONTAL = 0x11;
    const VERTICAL   = 0x12;

    const IMAGEROTATE      = 'imagerotate';
    const IMAGECONVOLUTION = 'imageconvolution';
    const IMAGEFILTER      = 'imagefilter';
    const IMAGELAYEREFFECT = 'imagelayereffect';

    protected static $_available_functions = array();

    public static $default_driver = 'GD';

    protected static $_checked = FALSE;

    //图片源文件
    public $file;

    //宽
    public $width;
    //高
    public $height;

    public $type;

    public $mime;

    public function __construct($file)
    {
        //如果还未对文件进行检查，则检查
        if (!self::$_checked) self::check();

        try {
            $file = realpath($file);
            $info = getimagesize($file);
        } catch (Exception $e) {
        }

        if (empty($file) OR empty($info))
        {
            throw new \Exception("Not an image or invalid image: $file");
        }

        $this->file   = $file;
        $this->width  = $info[0];
        $this->height = $info[1];
        $this->type   = $info[2];
        $this->mime   = image_type_to_mime_type($this->type);

        switch ($this->type)
        {
            case IMAGETYPE_JPEG:
                $create = 'imagecreatefromjpeg';
                break;
            case IMAGETYPE_GIF:
//                $create = 'imagecreatefromgif'; //如果是gif 不压缩
                break;
            case IMAGETYPE_PNG:
                $create = 'imagecreatefrompng';
                break;
        }

        if ( ! isset($create) OR ! function_exists($create))
        {
            throw new \Exception(
                sprintf('Installed GD does not support %s images', image_type_to_extension($this->type, FALSE)));
        }
        $this->_create_function = $create;
        $this->_image = $this->file;
    }

    public function factory($file)
    {
        return new self($file);
    }

    public function __destruct()
    {
        if (is_resource($this->_image)) {
            imagedestroy($this->_image);
        }
    }

    public function __toString()
    {
        return $this->render();
    }

    /**
     * 图片压缩方法一
     *
     */
    public function resize($width = NULL, $height = NULL, $master = NULL)
    {
        if ($master === NULL) {
            $master = self::AUTO;
        } elseif ($master == self::WIDTH AND ! empty($width)) {
            $master = self::AUTO;
            $height = NULL;
        } elseif ($master == self::HEIGHT AND ! empty($height)) {
            $master = self::AUTO;

            $width = NULL;
        }

        if (empty($width))
        {
            if ($master === self::NONE){
                $width = $this->width;
            } else {
                $master = self::HEIGHT;
            }
        }

        if (empty($height)) {
            if ($master === self::NONE) {
                $height = $this->height;
            } else {
                $master = self::WIDTH;
            }
        }

        switch ($master)
        {
            case self::AUTO:
                $master = ($this->width / $width) > ($this->height / $height) ? self::WIDTH : self::HEIGHT;
                break;
            case self::INVERSE:
                $master = ($this->width / $width) > ($this->height / $height) ? self::HEIGHT : self::WIDTH;
                break;
        }

        switch ($master)
        {
            case self::WIDTH:
                $height = $this->height * $width / $this->width;
                break;
            case self::HEIGHT:
                $width = $this->width * $height / $this->height;
                break;
            case self::PRECISE:
                $ratio = $this->width / $this->height;

                if ($width / $height > $ratio) {
                    $height = $this->height * $width / $this->width;
                } else {
                    $width = $this->width * $height / $this->height;
                }
                break;
        }

        $width  = max(round($width), 1);
        $height = max(round($height), 1);

        $this->_do_resize($width, $height);

        return $this;
    }

    /**
     * 图片压缩方法二
     */
    public function crop($width, $height, $offset_x = NULL, $offset_y = NULL)
    {
        if ($width > $this->width) $width = $this->width;

        if ($height > $this->height) $height = $this->height;

        if ($offset_x === NULL) {
            $offset_x = round(($this->width - $width) / 2);
        } elseif ($offset_x === TRUE) {
            $offset_x = $this->width - $width;
        } elseif ($offset_x < 0) {
            $offset_x = $this->width - $width + $offset_x;
        }

        if ($offset_y === NULL) {
            $offset_y = round(($this->height - $height) / 2);
        } elseif ($offset_y === TRUE) {
            $offset_y = $this->height - $height;
        } elseif ($offset_y < 0) {
            $offset_y = $this->height - $height + $offset_y;
        }

        $max_width  = $this->width  - $offset_x;
        $max_height = $this->height - $offset_y;

        if ($width > $max_width) $width = $max_width;
        if ($height > $max_height) $height = $max_height;

        $this->_do_crop($width, $height, $offset_x, $offset_y);

        return $this;
    }

    /**
     * 旋转
     */
    public function rotate($degrees)
    {
        $degrees = (int) $degrees;

        if ($degrees > 180) {
            do {
                $degrees -= 360;
            } while ($degrees > 180);
        }

        if ($degrees < -180) {
            do {
                $degrees += 360;
            } while ($degrees < -180);
        }

        $this->_do_rotate($degrees);

        return $this;
    }

    public function flip($direction)
    {
        if ($direction !== self::HORIZONTAL) {
            $direction = self::VERTICAL;
        }

        $this->_do_flip($direction);

        return $this;
    }

    public function sharpen($amount)
    {
        $amount = min(max($amount, 1), 100);

        $this->_do_sharpen($amount);

        return $this;
    }

    public function reflection($height = NULL, $opacity = 100, $fade_in = FALSE)
    {
        if ($height === NULL OR $height > $this->height) {
            $height = $this->height;
        }

        $opacity = min(max($opacity, 0), 100);

        $this->_do_reflection($height, $opacity, $fade_in);

        return $this;
    }

    public function watermark($watername, $offset_x = NULL, $offset_y = NULL, $opacity = 100)
    {
        if (is_file($watername)) {
            $watermark = new self($watername);
        } else {
            throw new \Exception('暂不支持文字水印');
        }
        if ($offset_x === NULL) {
            $offset_x = round(($this->width - $watermark->width));
        } elseif ($offset_x === TRUE) {
            $offset_x = $this->width - $watermark->width;
        } elseif ($offset_x < 0) {
            $offset_x = $this->width - $watermark->width + $offset_x;
        }

        if ($offset_y === NULL) {
            $offset_y = round(($this->height - $watermark->height));
        } elseif ($offset_y === TRUE) {
            $offset_y = $this->height - $watermark->height;
        } elseif ($offset_y < 0) {
            $offset_y = $this->height - $watermark->height + $offset_y;
        }

        $opacity = min(max($opacity, 1), 100);

        $this->_do_watermark($watermark, $offset_x, $offset_y, $opacity);

        return $this;
    }

    public function background($color, $opacity = 100)
    {
        if ($color[0] === '#') $color = substr($color, 1);

        if (strlen($color) === 3) $color = preg_replace('/./', '$0$0', $color);

        list ($r, $g, $b) = array_map('hexdec', str_split($color, 2));

        $opacity = min(max($opacity, 0), 100);

        $this->_do_background($r, $g, $b, $opacity);

        return $this;
    }

    public function save($file = NULL, $quality = 100)
    {
        if ($file === NULL) $file = $this->file;

        if (is_file($file)) {
            if ( ! is_writable($file)) {
                throw new \Exception("File must be writable: $file");
            }
        } else {
            $directory = realpath(pathinfo($file, PATHINFO_DIRNAME));

            if ( ! is_dir($directory) OR ! is_writable($directory)) {
                throw new \Exception("Directory must be writable: $directory");
            }
        }

        $quality = min(max($quality, 1), 100);

        return $this->_do_save($file, $quality);
    }

    public function render($type = NULL, $quality = 100)
    {
        if ($type === NULL) {
            $type = image_type_to_extension($this->type, FALSE);
        }

        return $this->_do_render($type, $quality);
    }


    public static function check()
    {
        if ( ! function_exists('gd_info')) {
            throw new \Exception('GD is either not installed or not enabled, check your configuration');
        }
        $functions = array(
            self::IMAGEROTATE,
            self::IMAGECONVOLUTION,
            self::IMAGEFILTER,
            self::IMAGELAYEREFFECT
        );
        foreach ($functions as $function) {
            self::$_available_functions[$function] = function_exists($function);
        }

        if (defined('GD_VERSION')) {
            $version = GD_VERSION;
        } else {
            $info = gd_info();

            preg_match('/\d+\.\d+(?:\.\d+)?/', $info['GD Version'], $matches);

            $version = $matches[0];
        }

        if ( ! version_compare($version, '2.0.1', '>=')) {
            throw new \Exception("Image_GD requires GD version 2.0.1 or greater, you have $version");
        }

        return self::$_checked = TRUE;
    }


    protected function _load_image()
    {
        if ( ! is_resource($this->_image)) {
            $create = $this->_create_function;

            $this->_image = $create($this->file);

            imagesavealpha($this->_image, TRUE);
        }
    }

    protected function _do_resize($width, $height)
    {
        $pre_width = $this->width;
        $pre_height = $this->height;

        $this->_load_image();

        if ($width > ($this->width / 2) AND $height > ($this->height / 2)) {
            $reduction_width  = round($width  * 1.1);
            $reduction_height = round($height * 1.1);

            while ($pre_width / 2 > $reduction_width AND $pre_height / 2 > $reduction_height) {
                $pre_width /= 2;
                $pre_height /= 2;
            }

            $image = $this->_create($pre_width, $pre_height);

            if (imagecopyresized($image, $this->_image, 0, 0, 0, 0, $pre_width, $pre_height, $this->width, $this->height)) {
                imagedestroy($this->_image);
                $this->_image = $image;
            }
        }

        $image = $this->_create($width, $height);

        if (imagecopyresampled($image, $this->_image, 0, 0, 0, 0, $width, $height, $pre_width, $pre_height)) {
            imagedestroy($this->_image);
            $this->_image = $image;

            $this->width  = imagesx($image);
            $this->height = imagesy($image);
        }
    }

    protected function _do_crop($width, $height, $offset_x, $offset_y)
    {
        $image = $this->_create($width, $height);

        $this->_load_image();

        if (imagecopyresampled($image, $this->_image, 0, 0, $offset_x, $offset_y, $width, $height, $width, $height)) {
            imagedestroy($this->_image);
            $this->_image = $image;

            $this->width  = imagesx($image);
            $this->height = imagesy($image);
        }
    }

    protected function _do_rotate($degrees)
    {
        if (empty(self::$_available_functions[self::IMAGEROTATE])) {
            throw new \Exception('This method requires imagerotate which is only available in the bundled version of GD');
        }

        $this->_load_image();

        $transparent = imagecolorallocatealpha($this->_image, 0, 0, 0, 127);

        $image = imagerotate($this->_image, 360 - $degrees, $transparent, 1);

        imagesavealpha($image, TRUE);

        $width  = imagesx($image);
        $height = imagesy($image);

        if (imagecopymerge($this->_image, $image, 0, 0, 0, 0, $width, $height, 100)) {
            imagedestroy($this->_image);
            $this->_image = $image;

            $this->width  = $width;
            $this->height = $height;
        }
    }

    protected function _do_flip($direction)
    {
        $flipped = $this->_create($this->width, $this->height);

        $this->_load_image();

        if ($direction === self::HORIZONTAL) {
            for ($x = 0; $x < $this->width; $x++) {
                imagecopy($flipped, $this->_image, $x, 0, $this->width - $x - 1, 0, 1, $this->height);
            }
        } else {
            for ($y = 0; $y < $this->height; $y++) {
                imagecopy($flipped, $this->_image, 0, $y, 0, $this->height - $y - 1, $this->width, 1);
            }
        }

        imagedestroy($this->_image);
        $this->_image = $flipped;

        $this->width  = imagesx($flipped);
        $this->height = imagesy($flipped);
    }

    protected function _do_sharpen($amount)
    {
        if (empty(self::$_available_functions[self::IMAGECONVOLUTION])) {
            throw new \Exception('This method requires imageconvolution, which is only available in the bundled version of GD');
        }

        $this->_load_image();

        $amount = round(abs(-18 + ($amount * 0.08)), 2);

        $matrix = [
            [-1,   -1,    -1],
            [-1, $amount, -1],
            [-1,   -1,    -1]
        ];

        if (imageconvolution($this->_image, $matrix, $amount - 8, 0)) {
            $this->width  = imagesx($this->_image);
            $this->height = imagesy($this->_image);
        }
    }

    protected function _do_reflection($height, $opacity, $fade_in)
    {
        if (empty(self::$_available_functions[self::IMAGEFILTER])) {
            throw new \Exception('This method requires imagefilter, which is only available in the bundled version of GD');
        }

        $this->_load_image();

        $opacity = round(abs(($opacity * 127 / 100) - 127));

        if ($opacity < 127) {
            $stepping = (127 - $opacity) / $height;
        } else {
            $stepping = 127 / $height;
        }

        $reflection = $this->_create($this->width, $this->height + $height);

        imagecopy($reflection, $this->_image, 0, 0, 0, 0, $this->width, $this->height);

        for ($offset = 0; $height >= $offset; $offset++) {
            $src_y = $this->height - $offset - 1;

            $dst_y = $this->height + $offset;

            if ($fade_in === TRUE) {
                $dst_opacity = round($opacity + ($stepping * ($height - $offset)));
            } else {
                $dst_opacity = round($opacity + ($stepping * $offset));
            }

            $line = $this->_create($this->width, 1);

            imagecopy($line, $this->_image, 0, 0, 0, $src_y, $this->width, 1);

            imagefilter($line, IMG_FILTER_COLORIZE, 0, 0, 0, $dst_opacity);

            imagecopy($reflection, $line, 0, $dst_y, 0, 0, $this->width, 1);
        }

        imagedestroy($this->_image);
        $this->_image = $reflection;

        $this->width  = imagesx($reflection);
        $this->height = imagesy($reflection);
    }

    protected function _do_watermark(self $watermark, $offset_x, $offset_y, $opacity)
    {
//        if (empty(\Image_GD::$_available_functions[\Image_GD::IMAGELAYEREFFECT])) {
//            throw new \Exception('This method requires imagelayereffect, which is only available in the bundled version of GD');
//        }
        $this->_load_image();

        $overlay = imagecreatefromstring($watermark->render());

        imagesavealpha($overlay, TRUE);

        $width  = imagesx($overlay);
        $height = imagesy($overlay);

        if ($opacity < 100) {
            $opacity = round(abs(($opacity * 127 / 100) - 127));

            $color = imagecolorallocatealpha($overlay, 127, 127, 127, $opacity);

            imagelayereffect($overlay, IMG_EFFECT_OVERLAY);

            imagefilledrectangle($overlay, 0, 0, $width, $height, $color);
        }

        imagealphablending($this->_image, TRUE);

        if (imagecopy($this->_image, $overlay, $offset_x, $offset_y, 0, 0, $width, $height)) {
            imagedestroy($overlay);
        }
    }

    protected function _do_background($r, $g, $b, $opacity)
    {
        $this->_load_image();

        $opacity = round(abs(($opacity * 127 / 100) - 127));

        $background = $this->_create($this->width, $this->height);

        $color = imagecolorallocatealpha($background, $r, $g, $b, $opacity);

        imagefilledrectangle($background, 0, 0, $this->width, $this->height, $color);

        imagealphablending($background, TRUE);

        if (imagecopy($background, $this->_image, 0, 0, 0, 0, $this->width, $this->height)) {
            imagedestroy($this->_image);
            $this->_image = $background;
        }
    }

    protected function _do_save($file, $quality)
    {
        $this->_load_image();

        $extension = pathinfo($file, PATHINFO_EXTENSION);

        list($save, $type) = $this->_save_function($extension, $quality);

        $status = isset($quality) ? $save($this->_image, $file, $quality) : $save($this->_image, $file);

        if ($status === TRUE AND $type !== $this->type) {
            $this->type = $type;
            $this->mime = image_type_to_mime_type($type);
        }

        return TRUE;
    }

    protected function _do_render($type, $quality)
    {
        $this->_load_image();

        list($save, $type) = $this->_save_function($type, $quality);

        ob_start();

        $status = isset($quality) ? $save($this->_image, NULL, $quality) : $save($this->_image, NULL);

        if ($status === TRUE AND $type !== $this->type) {
            $this->type = $type;
            $this->mime = image_type_to_mime_type($type);
        }

        return ob_get_clean();
    }

    protected function _save_function($extension, & $quality)
    {
        if ( ! $extension) {
            $extension = image_type_to_extension($this->type, FALSE);
        }

        switch (strtolower($extension)) {
            case 'jpg':
            case 'jpeg':
                $save = 'imagejpeg';
                $type = IMAGETYPE_JPEG;
                break;
            case 'gif':
                $save = 'imagegif';
                $type = IMAGETYPE_GIF;

                $quality = NULL;
                break;
            case 'png':
                $save = 'imagepng';
                $type = IMAGETYPE_PNG;

                $quality = 9;
                break;
            default:
                throw new \Exception("Installed GD does not support $extension images");
                break;
        }

        return array($save, $type);
    }

    protected function _create($width, $height)
    {
        $image = imagecreatetruecolor($width, $height);

        imagealphablending($image, FALSE);

        imagesavealpha($image, TRUE);

        return $image;
    }

    /**
     * 两种压缩方法同时使用
     */
    public function resize_crop($width, $height)
    {
        $this->resize($width, $height, self::INVERSE);
        $this->crop($width, $height);
        return $this;
    }
} 
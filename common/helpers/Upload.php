<?php
/**
 * 
 * ibagou.com
 * ============================================================================
 * 版权所有: ibagou.com
 * 网站地址: http://www.ylwkj.com/
 * ----------------------------------------------------------------------------
 * 许可声明：。
 * ============================================================================
 * Author: wsq(wansq@ylwkj.com)
 * Date: 14-11-27 下午9:10
 */

namespace common\helpers;

use Yii;
use yii\web\UploadedFile;
use common\helpers\Image;

class Upload {

    /**
     * 图片缩略
     * @param $filename
     * @param string $type
     *
     */
    public static function thumb($filename, $type = 'article')
    {
        $thumb = Yii::$app->params['thumb'][$type];
        if (empty($thumb)) return;
        $savePath = dirname($filename);
        $image = new Image($filename);
        foreach ($thumb as $k => $v) {
            $img = clone $image;
            $arr = explode('@',$v);
            $size = explode('*', $arr[0]);
            $method = isset($arr[1]) ? $arr[1] : 'resize_crop';
            $img->$method($size[0], $size[1])->save($savePath . '/' . $k . basename($filename));
        }
    }

    /**
     * 水印
     * @param $filename
     * @param $waterPic
     */
    public static function water($filename, $waterPic=null)
    {
        $waterPic = empty($waterPic) ? Yii::$app->params['water'] : $waterPic;
        $image = new Image($filename);
        $image->watermark($waterPic)->save($filename);
    }
} 
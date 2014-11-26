<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        // 'static/back/css/site.css',
        'static/common/bootstrap/css/bootstrap.min.css',
        'static/back/css/font-awesome.min.css',
        'static/common/css/jquery-ui.min.css',
        'static/back/css/ace.min.css',//要在jquery-ui.min.css之后
        'static/back/css/common.css',
    ];

    public $js = [
        'static/common/bootstrap/js/bootstrap.min.js',
        'static/back/js/ace-extra.min.js',
        'static/back/js/ace.min.js',
        'static/common/js/common.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',

    ];
    public $jsOptions = [
        // 'position' => View::POS_HEAD,
    ];
}














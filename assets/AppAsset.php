<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/animate.min.css',
        'css/bootstrap-litera.css',
        'css/bootstrap-select.min.css',
        'css/site.css',
        'js/katex/katex.min.css',
        'js/highlight/styles/default.css'
    ];
    public $js = [
        'js/bootstrap-select.min.js',
        'js/highlight/highlight.pack.js',
        'js/katex/katex.min.js',
        'js/socket.io.js',
        'js/clipboard.min.js',
        'js/app.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'app\assets\FontAwesomeAsset',
    ];
}

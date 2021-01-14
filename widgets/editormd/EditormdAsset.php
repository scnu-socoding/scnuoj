<?php
namespace app\widgets\editormd;

use yii\web\AssetBundle;

/**
 * @author Shiyang <dr@shiyang.me>
 */
class EditormdAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/editormd/assets';
    public $js = [
        'editormd.js'
    ];
    public $css = [
        'css/editormd.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}

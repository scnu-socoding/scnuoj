<?php
namespace app\widgets\codemirror;

use yii\web\AssetBundle;

/**
 * @author Shiyang <dr@shiyang.me>
 */
class CodeMirrorAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/codemirror/assets';
    public $js = [
        'lib/codemirror.js',
        'addon/selection/active-line.js',
        'addon/edit/matchbrackets.js',
        'addon/display/autorefresh.js',
        'mode/javascript/javascript.js'
    ];
    public $css = [
        'lib/codemirror.css',
        'theme/material.css'
    ];
    public $depends = [
    ];
}

<?php
/**
 * @author Di Zhang <alex@extong.net>
 */

namespace yiizh\redactor;

use yii\web\AssetBundle;

class RedactorAsset extends AssetBundle
{
    public $sourcePath = '@yiizh/redactor/assets';

    public $js = [
        'redactor.min.js',
    ];

    public $css = [
        'redactor.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
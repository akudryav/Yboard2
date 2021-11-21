<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Для чата
 */
class ChatAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/chat.css',
    ];
    public $js = [
        'js/chat.js',
    ];
    public $depends = [
        'app\assets\AppAsset',
    ];
}

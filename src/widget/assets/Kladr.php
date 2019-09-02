<?php

namespace devsergeev\yii2KladrModule\widget\assets;

use yii\web\AssetBundle;

class Kladr extends AssetBundle
{
    public $sourcePath = '@devsergeev/yii2KladrModule/widget/resources';
    public $js = ['kladr.js'];
    public $css = ['kladr.css'];
    public $depends = [
        Select2Bootstrap4::class,
    ];
}

<?php

namespace devsergeev\yii2KladrModule\widget\assets;

use yii\web\AssetBundle;
use yii\bootstrap4\BootstrapAsset;

class Select2Bootstrap4 extends AssetBundle
{
    public $sourcePath = '@devsergeev/yii2KladrModule/widget/resources';
    public $css = ['select2-bootstrap.min.css'];
    public $depends = [
        BootstrapAsset::class,
        Select2::class,
    ];
}

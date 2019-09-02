<?php

namespace devsergeev\yii2KladrModule\widget\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class Select2 extends AssetBundle
{
    public $sourcePath = '@npm/select2/dist';
    public $css = ['css/select2.css',];
    public $js = ['js/select2.full.js', 'js/i18n/ru.js'];
    public $depends = [
        JqueryAsset::class,
    ];
}

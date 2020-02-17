<?php

namespace devsergeev\yii2KladrModule\widget\assets;

use yii\web\AssetBundle;

class AddressFilterAsset extends AssetBundle
{
    public $sourcePath = '@devsergeev/yii2KladrModule/widget/resources';
    public $js = ['address-input.js'];
    public $depends = [
        Select2Bootstrap4::class,
    ];
}

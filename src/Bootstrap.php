<?php

namespace devsergeev\yii2KladrModule;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $app->setModule('kladr', ['class' => Module::class]);
    }
}
<?php

namespace devsergeev\yii2KladrModule\widget;

class KladrWidget extends \yii\base\Widget
{
    /** @var \yii\widgets\ActiveForm */
    public $form;

    /** @var \yii\db\ActiveRecord */
    public $model;

    /** @var string */
    public $attribute;

    public function run(): string
    {
        return $this->render('form');
    }
}

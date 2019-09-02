<?php

namespace devsergeev\yii2KladrModule\widget;

class Widget extends \yii\base\Widget
{
    public $model;
    public $attribute;
    public $form;

    public function run(): string
    {
        return $this->render('form', ['form' => $this->form, 'model' => $this->model, 'attribute' => $this->attribute]);
    }
}

<?php

namespace devsergeev\yii2KladrModule\widget;

use yii\base\Widget;
use yii\bootstrap4\Html;
use devsergeev\yii2KladrModule\widget\assets\AddressFilterAsset;

class AddressSearchWidget extends Widget
{
    /** @var \yii\db\ActiveRecord */
    public $searchModel;

    /** @var string */
    public $attribute;

    public function run(): string
    {
        AddressFilterAsset::register($this->view);
        return Html::dropDownList('', null, [], ['style' => 'width: 100%;', 'id' => 'searchedAddress'])
            . Html::activeHiddenInput($this->searchModel, $this->attribute);
    }
}

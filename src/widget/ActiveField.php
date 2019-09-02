<?php

namespace devsergeev\yii2KladrModule\widget;

class ActiveField extends \yii\bootstrap4\ActiveField
{
    public function kladr($options = [])
    {
        $options = array_merge($this->inputOptions, $options);

        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Widget::widget(['form' => $this->form, 'model' => $this->model, 'attribute' => $this->attribute]);




        return $this;
    }
}
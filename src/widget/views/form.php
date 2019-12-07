<?php
devsergeev\yii2KladrModule\widget\assets\Kladr::register($this);
?>
<div id="kladr-block">
    <div class="form-group row">
        <label for="kladr-select-region" class="col-sm-2 col-form-label">Регион</label>
        <div class="col-sm-10">
            <select id="kladr-select-region" name="kladr-select-region" class="form-control"></select>
        </div>
    </div>
    <div class="form-group row">
        <label for="kladr-select-district" class="col-sm-2 col-form-label">Район</label>
        <div class="col-sm-10">
            <select id="kladr-select-district" name="kladr-select-district" class="form-control"></select>
        </div>
    </div>
    <div class="form-group row">
        <label for="kladr-select-city" class="col-sm-2 col-form-label">Город</label>
        <div class="col-sm-10">
            <select id="kladr-select-city" name="kladr-select-city" class="form-control"></select>
        </div>
    </div>
    <div class="form-group row">
        <label for="kladr-select-locality" class="col-sm-2 col-form-label">Нас. пункт</label>
        <div class="col-sm-10">
            <select id="kladr-select-locality" name="kladr-select-locality" class="form-control"></select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-10 offset-md-2">
            <button id="kladr-button-reset" class="btn btn-secondary btn-sm" disabled>Сбросить адрес</button>
        </div>
    </div>

    <?php
    /** @var $context devsergeev\yii2KladrModule\widget\KladrWidget */
    $context = $this->context;
    echo $context->form->field($context->model, $context->attribute)->hiddenInput()
    ?>
</div>
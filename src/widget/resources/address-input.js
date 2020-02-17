(function ($) {

    const $searchedAddress = $('#searchedAddress'),
        $currentAddress = $('[name="ClientSearch[contragent.address]"]');

    $searchedAddress.select2({
        theme: 'bootstrap',
        language: 'ru',
        ajax: {
            url: '/kladr/default/search-address-by-string',
            dataType: 'json',
            data: function (params) {
                return {
                    string: params.term
                }
            },
            delay: 250,
            cache: true,
        },
        allowClear: true,
        minimumInputLength: 1,
        placeholder: 'Введите адрес'
    }).on('change', function () {
        $currentAddress.val($searchedAddress.val()).triggerHandler('change');
    });

    const currentAddressCode = $currentAddress.val();
    if (currentAddressCode) {
        $.ajax({
            url: '/kladr/default/get-string-address-by-code',
            dataType: 'json',
            data: {code: currentAddressCode},
            cache: true,
            success: function (data) {
                $searchedAddress.append(new Option(data, currentAddressCode, true, true));
            }
        });
    }
}(jQuery));
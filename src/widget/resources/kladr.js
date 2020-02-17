(function ($) {

    const
        $kladrSelectRegion = $('#kladr-select-region'),
        $kladrSelectDistrict = $('#kladr-select-district'),
        $kladrSelectCity = $('#kladr-select-city'),
        $kladrSelectLocality = $('#kladr-select-locality'),
        $kladrSelectCode = $('#updatecontragent-address, #createcontragent-address'),
        $kladrSelectReset = $('#kladr-button-reset');

    $kladrSelectRegion.select2({
        theme: 'bootstrap',
        language: 'ru',
        ajax: {
            url: '/kladr/default/get-region-list',
            dataType: 'json',
            data: function (params) {
                return {
                    name: params.term
                }
            },
            delay: 250,
            cache: true,
        },
        allowClear: true,
        minimumInputLength: 1,
        placeholder: 'Выберите регион'
    });

    $kladrSelectRegion.on('select2:select', function (e) {
        $kladrSelectDistrict.val(null).trigger('change');
        $kladrSelectCity.val(null).trigger('change');
        $kladrSelectLocality.val(null).trigger('change');

        $kladrSelectCode.val($(this).val());
        $kladrSelectReset.attr('disabled', false);
    });

    $kladrSelectRegion.on('select2:unselecting', function (e) {
        $kladrSelectDistrict.val(null).trigger('change');
        $kladrSelectCity.val(null).trigger('change');
        $kladrSelectLocality.val(null).trigger('change');
    });




    $kladrSelectDistrict.select2({
        theme: 'bootstrap',
        language: 'ru',
        ajax: {
            url: '/kladr/default/get-district-list',
            dataType: 'json',
            data: function (params) {
                let region = $kladrSelectRegion.val();
                region = region ? region.substr(0, 2) : null;
                return {
                    region: region,
                    name: params.term
                }
            },
            delay: 250,
            cache: true,
        },
        templateResult: function (state) {
            let html = '';
            if (state.text) {
                html += '<span>' + state.text + '</span>';
            }
            if (state.region && state.region.text) {
                html += '<span class="parents-address">, ' + state.region.text + '</span>'
            }
            return $('<div>' + html + '</div>');
        },
        allowClear: true,
        minimumInputLength: 1,
        placeholder: 'Выберите район'
    });

    $kladrSelectDistrict.on('select2:select', function (e) {
        const data = e.params.data;
        if (data.region && data.region.id && !$kladrSelectRegion.val()) {
            $kladrSelectRegion.append(new Option(data.region.text, data.region.id, true, true)).trigger('change');
        }

        $kladrSelectCity.val(null).trigger('change');
        $kladrSelectLocality.val(null).trigger('change');

        $kladrSelectCode.val($(this).val());
        $kladrSelectReset.attr('disabled', false);
    });

    $kladrSelectDistrict.on('select2:unselecting', function (e) {
        $kladrSelectCity.val(null).trigger('change');
        $kladrSelectLocality.val(null).trigger('change');
    });




    $kladrSelectCity.select2({
        theme: 'bootstrap',
        language: 'ru',
        ajax: {
            url: '/kladr/default/get-city-list',
            dataType: 'json',
            data: function (params) {
                let region = $kladrSelectRegion.val();
                region = region ? region.substr(0, 2) : null;
                let district = $kladrSelectRegion.val();
                district = district ? district.substr(2, 3) : null;
                return {
                    region: region,
                    district: district,
                    name: params.term
                }
            },
            delay: 500,
            cache: true,
        },
        templateResult: function (state) {
            let html = '';
            if (state.text) {
                html += '<span>' + state.text + '</span>';
            }
            if (state.district && state.district.text) {
                html += '<span class="parents-address">, ' + state.district.text + '</span>'
            }
            if (state.region && state.region.text) {
                html += '<span class="parents-address">, ' + state.region.text + '</span>'
            }
            return $('<div>' + html + '</div>');
        },
        allowClear: true,
        minimumInputLength: 1,
        placeholder: 'Выберите город'
    });

    $kladrSelectCity.on('select2:select', function (e) {

        const data = e.params.data;
        if (data.region && data.region.id && !$kladrSelectRegion.val()) {
            $kladrSelectRegion.append(new Option(data.region.text, data.region.id, true, true)).trigger('change');
        }
        if (data.district && data.district.id  && data.district.text && !$kladrSelectDistrict.val()) {
            $kladrSelectDistrict.append(new Option(data.district.text, data.district.id, true, true)).trigger('change');
        }
        $kladrSelectLocality.val(null).trigger('change');

        $kladrSelectCode.val($(this).val());
        $kladrSelectReset.attr('disabled', false);

    });

    $kladrSelectDistrict.on('select2:unselecting', function (e) {
        $kladrSelectLocality.val(null).trigger('change');
    });



    $kladrSelectLocality.select2({
        theme: 'bootstrap',
        language: 'ru',
        ajax: {
            url: '/kladr/default/get-locality-list',
            dataType: 'json',
            data: function (params) {
                let region = $kladrSelectRegion.val();
                region = region ? region.substr(0, 2) : null;
                let district = $kladrSelectRegion.val();
                district = district ? district.substr(2, 3) : null;
                let city = $kladrSelectRegion.val();
                city = city ? city.substr(5, 3) : null;
                return {
                    region: region,
                    district: district,
                    city: city,
                    name: params.term
                }
            },
            delay: 750,
            cache: true,
        },
        templateResult: function (state) {
            let html = '';
            if (state.text) {
                html += '<span>' + state.text + '</span>';
            }
            if (state.city && state.city.text) {
                html += '<span class="parents-address">, ' + state.city.text + '</span>'
            }
            if (state.district && state.district.text) {
                html += '<span class="parents-address">, ' + state.district.text + '</span>'
            }
            if (state.region && state.region.text) {
                html += '<span class="parents-address">, ' + state.region.text + '</span>'
            }
            return $('<div>' + html + '</div>');
        },
        allowClear: true,
        minimumInputLength: 1,
        placeholder: 'Выберите населенный пункт'
    });

    $kladrSelectLocality.on('select2:select', function (e) {

        const data = e.params.data;
        if (data.region && data.region.id && !$kladrSelectRegion.val()) {
            $kladrSelectRegion.append(new Option(data.region.text, data.region.id, true, true)).trigger('change');
        }
        if (data.district && data.district.id  && data.district.text && !$kladrSelectDistrict.val()) {
            $kladrSelectDistrict.append(new Option(data.district.text, data.district.id, true, true)).trigger('change');
        }
        if (data.city && data.city.id  && data.city.text && !$kladrSelectCity.val()) {
            $kladrSelectCity.append(new Option(data.city.text, data.city.id, true, true)).trigger('change');
        }

        $kladrSelectCode.val($(this).val());
        $kladrSelectReset.attr('disabled', false);
    });

    $kladrSelectReset.on('click', function () {
        $kladrSelectRegion.val(null).trigger('change');
        $kladrSelectDistrict.val(null).trigger('change');
        $kladrSelectCity.val(null).trigger('change');
        $kladrSelectLocality.val(null).trigger('change');
        $kladrSelectCode.val(null);
        $kladrSelectReset.attr('disabled', true);
    });

    if ($kladrSelectCode.val()) {
        $.ajax({
            url: '/kladr/default/get-address-by-code',
            dataType: 'json',
            data: {code: $kladrSelectCode.val()},
            cache: true,
            success: function (data) {
                console.log(data);
                if (data.region && data.region > 0) {
                    $kladrSelectRegion.append(new Option(data.pNameRegion, data.region, true, true)).trigger('change');
                }
                if (data.district && data.district > 0) {
                    $kladrSelectDistrict.append(new Option(data.pNameDistrict, data.district, true, true)).trigger('change');
                }
                if (data.city && data.city > 0) {
                    $kladrSelectCity.append(new Option(data.pNameCity, data.city, true, true)).trigger('change');
                }
                if (data.locality && data.locality > 0) {
                    $kladrSelectLocality.append(new Option(data.pNameLocality, data.locality, true, true)).trigger('change');
                }
                $kladrSelectReset.attr('disabled', false);
            }
        });
    }

}(jQuery));
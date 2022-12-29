jQuery(function ($) {
    let deliveryTypeInput = $('#billing_delivery_type')
    deliveryTypeInput.css('display', 'none')
    let newSelect = document.createElement('select')
    newSelect.name = 'deliveryType'
    newSelect.id = 'deliveryType'
    const options = [
        {
            title: "Вибиріть тип доставки",
            value: "check"
        },
        {
            title: "Відділення",
            value: "warehouse"
        },
        {
            title: "за адресою",
            value: "courier"
        }
    ]

    options.forEach((element,key) => {
        if(element.value === 'check'){
            newSelect[key] = new Option(element.title, element.value, true)
        } else{
            newSelect[key] = new Option(element.title, element.value);
        }
    });

    newSelect.querySelectorAll('option').forEach(opt => {
        if (opt.value == "check") {
            opt.disabled = true;
        }
    });

    deliveryTypeInput.before(newSelect)

    document.getElementById('billing_city').setAttribute('disabled', true)
    document.getElementById('billing_courier').setAttribute('disabled', true)
    document.getElementById('billing_warehouse').setAttribute('disabled', true)


    let typeInput = $('#deliveryType')
    let courierAdressField = $('#billing_courier').parents('.form-row')
    let warehouseField = $('#billing_warehouse').parents('.form-row')

    typeInput.change(function(event){
        let val = event.target.value
        deliveryTypeInput.val(event.target.value)
        if(val === 'courier'){
            $(courierAdressField).removeClass('hideInput')
            $(warehouseField).addClass('hideInput')
            $('#billing_city').removeAttr('disabled')
        } else if(val === 'warehouse'){
            $('#billing_city').removeAttr('disabled')
            $(courierAdressField).addClass('hideInput')
            $(warehouseField).removeClass('hideInput')
        }
    })

    let citiesList = [];

    $('#billing_city').autocomplete({
        source: function (request, response) {

            let np_key_api = np_key.key
            let data = {
                "apiKey": np_key_api,
                "modelName": "Address",
                "calledMethod": "getCities",
                "methodProperties": {
                    "FindByString": request.term,
                    "Limit": "10",
                    "Page": "1"
                }
            }

            $.ajax({
                url: "https://api.novaposhta.ua/v2.0/json/",
                method: "POST",
                data: JSON.stringify(data),
                success: function (resdata) {
                    let cities = []
                    if (resdata.data.length != 0) {
                        let details = resdata.data

                        for (const [key, value] of Object.entries(details)) {
                            let city = {
                                label: value.Description,
                                value: value.Description,
                                ref: value.Ref
                            }
                            cities.push(city)
                        }
                    }
                    response(cities)
                },
            });
        },

        messages: {
            noResults: "dasads.",
            results: function (amount) {
                return amount + (amount > 1 ? " results are" : " result is") +
                    " available, use up and down arrow keys to navigate.";
            }
        },

        select: function (event, ui) {
            let input = event.target
            $(input).attr('data-city-name', ui.item.label)
            $(input).attr('data-city-ref', ui.item.ref)
            $('#billing_warehouse').removeAttr('disabled')
            $('#billing_courier').removeAttr('disabled')
            $(input).val(ui.item.label)
        }
    }).autocomplete("widget").addClass("cityList");


    $('#billing_warehouse').autocomplete({
        source: function (request, response) {
            let np_key_api = np_key.key
            let cityName = $('#billing_city').attr('data-city-name')
            let cityRef = $('#billing_city').attr('data-city-ref')

            let data = {
                "apiKey": np_key_api,
                "modelName": "Address",
                "calledMethod": "getWarehouses",
                "methodProperties": {
                    "CityName": cityName,
                    // "CityRef": cityRef,
                    "FindByString": request.term,
                    "Limit": "20",
                    "Page": "1"
                }
            }

            $.ajax({
                url: "https://api.novaposhta.ua/v2.0/json/",
                method: "POST",
                data: JSON.stringify(data),
                success: function (resdata) {
                    let whs = []

                    if (resdata.data.length != 0) {
                        let details = resdata.data

                        for (const [key, value] of Object.entries(details)) {
                            let wh = {
                                label: value.Description,
                                value: value.Description,
                                adress: value.ShortAddress
                            }
                            whs.push(wh)
                        }
                    }
                    response(whs)
                },
            });
        }
    }).autocomplete("widget").addClass("cityList");
})
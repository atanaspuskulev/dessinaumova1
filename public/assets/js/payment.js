let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

paypal.Buttons({
    fundingSource: paypal.FUNDING.PAYPAL,
    createOrder: function(data, actions) {
        fetch(orderCreateUrl, {
            method: 'post',
            headers: {
            'content-type': 'application/json',
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": token
            },
            body: JSON.stringify(orderInfo)
        }).then(response => {
            if (!response.ok) {
               window.location.href = paypalCancelUrl;
            }
        }).catch(error => {
           window.location.href = paypalCancelUrl;
        });

        return actions.order.create({
            application_context: {
                brand_name : paypalBrandName,
                user_action : 'PAY_NOW',
                locale: paypalDefaultLocale,
                merchant_preferences: orderInfo.merchant_preferences
            },
            purchase_units: orderInfo.purchase_units,
        });
    },
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(response) {
            if(response.id && response.intent === 'CAPTURE' && response.status === 'COMPLETED') {
                completeOrder(response);
            } else {
                cancelOrder(response);
                window.location.href = paypalCancelUrl
            }
        });
    },
    onCancel: function(orderId, data, data2, data3) {
        cancelOrder(orderId);
        window.location.href = paypalCancelUrl
    }
}).render('#paypal-button-container');

$(function() {
    $('#credit-card-form').on('submit', function(event) {
        event.preventDefault();

        const billingData = {
            address_line_1: $('billing-address').val(),
            admin_area_1: $('billing-state').val(),
            admin_area_2: $('billing-city').val(),
            postal_code: $('billing-zip').val(),
            country_code: $('billing-country').val()
        };

        const createOrder = (data, actions) => {

        }
    });
})

function cancelOrder(data) {
    fetch(apiCancelUrl, {
        method: 'post',
        headers: {
            'content-type': 'application/json',
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify(data)
    });
}

function completeOrder(data) {
    fetch(orderUpdateUrl, {
        method: 'post',
        headers: {
            'content-type': 'application/json',
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify(data)
    }).then(response => {
        if(!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        //window.location.href = paypalSuccessUrl;
    }).catch(error => {
        console.error('Fetch error:', error);
    });
}




function showCardForm() {
   document.querySelector('.pp-ccpay').classList.remove('d-none');
   document.querySelector('.pp-fastpay').classList.add('d-none');
   document.querySelector('.show-cc-payment').classList.add('d-none');
}

function showFastPay() {
    document.querySelector('.pp-ccpay').classList.add('d-none');
    document.querySelector('.pp-fastpay').classList.remove('d-none');
    document.querySelector('.show-cc-payment').classList.remove('d-none');
}

$(function() {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    let acceptPostHeaders = {
        "Accept": "application/json, text-plain, */*",
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": csrfToken,
    };

    const showLoading = (show) => {
        if(show) {
            $('#loading').removeClass('d-none');
        } else {
            $('#loading').addClass('d-none');
        }
    }

    const message = (msg) => {
        $('#paymentResponse').text(msg);
        setTimeout(() => {
            $('#paymentResponse').addClass('d-none').text('');
        }, 5000);
    }

    paypal.Buttons({
        createOrder: function (data) {
            showLoading(true);
            return fetch(orderCreateUrl, {
                method: "POST",
                headers: acceptPostHeaders,
                body: JSON.stringify({
                    paymentMethod: 'paypal',
                    paymentSource: data.paymentSource,
                    order: orderInfo,
                    shipping_cost: shippingCost
                })
            }).then((res) => {
                return res.json();
            }).then((result) => {
                showLoading(false);
                if(result.status == true){
                    return result.data.id;
                } else {
                    message(result.message);
                    return false;
                }
            });
        },
        onApprove: function (data) {
            return fetch(orderUpdateUrl, {
                method: "POST",
                headers: acceptPostHeaders,
                body: JSON.stringify({
                    orderId: data.orderID,
                    paymentMethod: data.paymentSource
                })
            }).then((response) => response.json()).then((orderData) => {
                window.location.href = paypalSuccessUrl;
            });
        },
        onCancel: function(data) {
            window.location.href = paypalCancelUrl + '?orderID= ' + data.orderID;
        },
        onError: function (error) {
            message(error);
        },
    }).render("#paypal-button-container");
});

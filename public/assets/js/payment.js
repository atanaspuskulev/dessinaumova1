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
                    order: orderInfo
                })
            })
                .then((res) => {
                    return res.json();
                })
                .then((result) => {
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
            })
                .then((response) => response.json())
                .then((orderData) => {
                    window.location.href = paypalSuccessUrl;
                });
        },
        onError: function (error) {
            message(error);
        },
    }).render("#paypal-button-container");

// Create the Card Fields Component and define callbacks
    const cardField = paypal.CardFields({
        createOrder: function (data) {
            console.log(data);
            return fetch(paypalCancelUrl, {
                method: "POST",
                body: {
                    paymentSource: data.paymentSource,
                },
            })
                .then((res) => {
                    return res.json();
                })
                .then((orderData) => {
                    return orderData.id;
                });
        },
        onApprove: function (data) {
            const {orderID} = data;
            return fetch(paypalCancelUrl, {
                method: "POST",
            })
                .then((res) => {
                    return res.json();
                })
                .then((orderData) => {
                    // Redirect to success page
                });
        },
        onError: function (error) {
// Do something with the error from the SDK
        },
    });
// Render each field after checking for eligibility
    if (cardField.isEligible()) {
        const nameField = cardField.NameField();
        nameField.render("#card-name-field-container");

        const numberField = cardField.NumberField();
        numberField.render("#card-number-field-container");

        const cvvField = cardField.CVVField();
        cvvField.render("#card-cvv-field-container");

        const expiryField = cardField.ExpiryField();
        expiryField.render("#card-expiry-field-container");

        $("#card-field-submit-button").on("click", function() {
            cardField.submit({
                // From your billing address fields
                billingAddress: {}
            }).then(() => {
                // submit successful
            });
        });
    }
});



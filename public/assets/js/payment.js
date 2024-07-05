$(function() {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    let acceptPostHeaders = {
        "Accept": "application/json, text-plain, */*",
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": csrfToken,
    };

    paypal.Buttons({
        createOrder: function (data) {
console.log(data, orderInfo);
            return fetch(orderCreateUrl, {
                method: "POST",
                headers: acceptPostHeaders,
                // Use the "body" parameter to optionally pass additional order information
                // such as product ID or amount
                body: JSON.stringify({
                    paymentMethod: 'paypal',
                    paymentSource: data.paymentSource,  // Payment method ID
                    order: orderInfo
                })
            })
            .then(response => {
                // if (!response.ok) {
                //     window.location.href = paypalCancelUrl;
                // } else {
                //     alert("DA");
                // }
            }).catch(error => {
                window.location.href = paypalCancelUrl;
            });
        },
// Finalize the transaction after payer approval
        onApprove: function (data) {
            return fetch(paypalCancelUrl, {
                method: "POST",
            })
                .then((response) => response.json())
                .then((orderData) => {
                    // Successful capture! For dev/demo purposes:
                    console.log(
                        "Capture result",
                        orderData,
                        JSON.stringify(orderData, null, 2),
                    );
                    var transaction = orderData.purchase_units[0].payments.captures[0];
                    // Show a success message within this page. For example:
                    // var element = document.getElementById('paypal-button-container');
                    // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                    // Or go to another URL: actions.redirect('thank_you.html');
                });
        },
        onError: function (error) {
// Do something with the error from the SDK
        },
    })
        .render("#paypal-button-container");

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



paypal.Buttons({
    createOrder: function(data, actions) {
        return actions.order.create({
            application_context: {
                brand_name : paypalBrandName,
                user_action : 'PAY_NOW',
                locale: 'en-US',
                merchant_preferences: orderInfo.merchant_preferences
            },
            purchase_units: orderInfo.purchase_units,
        });
    },
    onApprove: function(data, actions) {
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        return actions.order.capture().then(function(response) {
            if(response.id && response.intent === 'CAPTURE' && response.status === 'COMPLETED') {

            } else {
                Livewire.emit('failedTransaction', 'Failed to capture PayPal order payment');
            }
        });
    },
    onCancel: function(data) {

    }
}).render('#paypal-button-container');

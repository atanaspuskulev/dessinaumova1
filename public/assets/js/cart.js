$(function() {
    if($('#__PRODUCT__').length > 0 && $('#buy-button').length > 0) {
        $('#buy-button').on('click', function() {
            axios.post(cart_add_url, {
                _token: $('input[name=_token]').val(),
                product_id: $('input[name=product_id]').val()
            }).then((response) => {
                console.log(response);
            });
        });
    }
});


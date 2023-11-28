$(function() {
    if($('#__PRODUCT__').length > 0 && $('#buy-button').length > 0) {
        $('#buy-button').on('click', function() {
            axios.post(cart_add_url, {
                _token: $('input[name=_token]').val(),
                product_id: $('input[name=product_id]').val()
            }).then((response) => {
                if(response.data.success) {
                    $('#__PRODUCT__').remove();
                    $('#cart-items-num').text(response.data.cart_count);
                    Swal.fire({
                        title: !response.data.continue ? 'Cart Info' : 'Cart Updated!',
                        text: response.data.message,
                        icon: 'success',
                        confirmButtonText: 'View Cart',
                        showDenyButton: true,
                        showCancelButton: true,
                        denyButtonText: 'Continue Browsing',
                        denyButtonColor: '#009F46'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = response.data.cart_url;
                        } else if (result.isDenied) {
                            // Continue browsing, do nothing (stay on the same page) or redirect as needed
                            window.location.href = '/'; // Example: Redirect to the home page
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error Updating Cart!',
                        text: response.data.message,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        });
    }
});


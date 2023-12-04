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
                            window.location.href = '/'; // Example: Redirect to the home page
                        } else if(result.isDismissed) {
                            window.location.reload();
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

function confirmRemove(productId) {
    Swal.fire({
        title: 'Remove From Cart',
        text: 'Are you sure you want to remove this product from the cart?',
        icon: 'warning',
        confirmButtonText: 'Remove',
        showCancelButton: true
    }).then((result) => {
        if(result.isConfirmed) {
            axios.post(removeFromCartUrl, {
                _token: $('meta[name="csrf-token"]').attr('content'),
                productId: productId
            }).then((response) => {
                if(response.data.success) {
                    $(`tr#${productId}`).fadeOut();
                    $('.total-price').html(`Total: ${response.data.total_price}&euro;`);
                } else {
                    Swal.fire({
                        title: 'Error Updating Cart!',
                        text: 'Something went wrong while trying to remove product from a list.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        }
    });
}

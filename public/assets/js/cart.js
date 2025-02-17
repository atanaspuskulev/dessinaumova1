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
                        title: !response.data.continue ? labels.cart_info : lables.cart_updated,
                        text: response.data.message,
                        icon: 'success',
                        confirmButtonText: labels.view_cart,
                        showDenyButton: true,
                        showCancelButton: true,
                        denyButtonText: labels.continue_browsing,
                        denyButtonColor: '#009F46'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = response.data.cart_url;
                        } else if (result.isDenied) {
                            window.location.href = '/';
                        } else if(result.isDismissed) {
                            window.location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        title: labels.error_update,
                        text: response.data.message,
                        icon: 'error',
                        confirmButtonText: labels.ok
                    });
                }
            });
        });
    }
});

function confirmRemove(productId) {
    Swal.fire({
        title: labels.remove_from_cart,
        text: labels.warning,
        icon: 'warning',
        confirmButtonText: labels.remove,
        showCancelButton: true
    }).then((result) => {
        if(result.isConfirmed) {
            axios.post(removeFromCartUrl, {
                _token: $('meta[name="csrf-token"]').attr('content'),
                productId: productId
            }).then((response) => {
                if(response.data.success) {
                    $('.cart-list').empty().html(response.data.html);
                } else {
                    Swal.fire({
                        title: labels.error_update,
                        text: labels.remove_err,
                        icon: 'error',
                        confirmButtonText: labels.ok
                    });
                }
            });
        }
    });
}

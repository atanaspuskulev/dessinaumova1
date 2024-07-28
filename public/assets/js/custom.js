const _csrf = $('meta[name="csrf-token"]').attr('content');

toastr.options = {
    "positionClass": "toast-bottom-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

let deleteImageModal;
let trashProductModal;
let destroyProductModal;
let restoreProductModal;
let orderModal;
let archiveProductUrl;
let destroyProductUrl;
let restoreProductUrl;
let destroyImageUrl;

let trashCategoryModal;
let destroyCategoryModal;
let restoreCategoryModal;
let archiveCategoryUrl;
let destroyCategoryUrl;
let restoreCategoryUrl;

$(function () {
    $('[data-toggle="tooltip"]').tooltip();

    if ($('.sortable-container').length > 0) {
        $(".sortable-container").sortable({
            items: ".sortable-item",
            cursor: "move",
            update: function (event, ui) {
                let sortedItems = $(this).sortable("toArray");
                $.ajax({
                    url: reorder_gallery_url,
                    method: "POST",
                    data: {
                        _token: _csrf,
                        product_id: productId,
                        order: sortedItems
                    },
                    success: function (response) {
                        toastr["success"]("Positioning saved!");
                    },
                    error: function (xhr, status, error) {
                        toastr["error"]("Error saving positioning!");
                    }
                });
            }
        });
    }

    if($('#product-list').length > 0) {
        $("#product-list").sortable({
            items: ".sortable-item-product",
            cursor: "move",
            handle: ".card-header",
            update: function (event, ui) {
                let sortedItems = $(this).sortable("toArray");
                $.ajax({
                    url: reorder_products_url,
                    method: "POST",
                    data: {
                        _token: _csrf,
                        order: sortedItems,
                        page: currentPage
                    },
                    success: function (response) {
                        toastr["success"]("Positioning saved!");
                    },
                    error: function (xhr, status, error) {
                        toastr["error"]("Error saving positioning!");
                    }
                });
            }
        });
    }

    if($('#deleteImage').length > 0) {
        deleteImageModal = $('#deleteImage');
    }
    if($('#orderModal').length > 0) {
        orderModal = $('#orderModal');
    }

    if($('#trashProduct').length > 0) {
        trashProductModal = $('#trashProduct');
    }

    if($('#destroyProduct').length > 0) {
        destroyProductModal = $('#destroyProduct');
    }

    if($('#untrashProduct').length > 0) {
        restoreProductModal = $('#untrashProduct');
    }

    if($('#trashCategory').length > 0) {
        trashCategoryModal = $('#trashCategory');
    }

    if($('#destroyCategory').length > 0) {
        destroyCategoryModal = $('#destroyCategory');
    }

    if($('#untrashCategory').length > 0) {
        restoreCategoryModal = $('#untrashCategory');
    }

    if($('textarea#description').length > 0) {
        ClassicEditor
            .create( document.querySelector( '#description' ))
            .catch( error => {
                console.error( error );
            } );
    }
});

function deleteImage(url) {
    deleteImageModal.modal('show');
    destroyImageUrl = url;
}

function trashProduct(url) {
    trashProductModal.modal('show');
    archiveProductUrl = url;
}

function destroyProduct(url) {
    destroyProductModal.modal('show');
    destroyProductUrl = url;
}

function restoreProduct(url) {
    restoreProductModal.modal('show');
    restoreProductUrl = url;
}

function trashCategory(url) {
    trashCategoryModal.modal('show');
    archiveCategoryUrl = url;
}

function destroyCategory(url) {
    destroyCategoryModal.modal('show');
    destroyCategoryUrl = url;
}

function restoreCategory(url) {
    restoreCategoryModal.modal('show');
    restoreCategoryUrl = url;
}

function trashProductAction() {
    if(archiveProductUrl) {
        $.ajax({
            url: archiveProductUrl,
            method: "DELETE",
            data: {
                _token: _csrf
            },
            success: function (response) {
                location.reload();
            },
            error: function (xhr, status, error) {
                toastr["error"]("Error archiving product!");
            }
        });
    }
}

function destoryProductAction() {
    if(destroyProductUrl) {
        $.ajax({
            url: destroyProductUrl,
            method: "DELETE",
            data: {
                _token: _csrf
            },
            success: function (response) {
                location.reload();
            },
            error: function (xhr, status, error) {
                toastr["error"]("Error permanently delete product!");
            }
        });
    }
}

function destoryImageAction() {
    if(destroyImageUrl) {
        $.ajax({
            url: destroyImageUrl,
            method: "DELETE",
            data: {
                _token: _csrf
            },
            success: function (response) {
                location.reload();
            },
            error: function (xhr, status, error) {
                toastr["error"]("Error deleting image!");
            }
        });
    }
}

function restoreProductAction() {
    if(restoreProductUrl) {
        $.ajax({
            url: restoreProductUrl,
            method: "POST",
            data: {
                _token: _csrf
            },
            success: function (response) {
                location.reload();
            },
            error: function (xhr, status, error) {
                toastr["error"]("Error restoring product state!");
            }
        });
    }
}

function trashCategoryAction() {
    if(archiveCategoryUrl) {
        $.ajax({
            url: archiveCategoryUrl,
            method: "DELETE",
            data: {
                _token: _csrf
            },
            success: function (response) {
                location.reload();
            },
            error: function (xhr, status, error) {
                toastr["error"]("Error archiving category!");
            }
        });
    }
}

function destoryCategoryAction() {
    if(destroyCategoryUrl) {
        $.ajax({
            url: destroyCategoryUrl,
            method: "DELETE",
            data: {
                _token: _csrf
            },
            success: function (response) {
                location.reload();
            },
            error: function (xhr, status, error) {
                toastr["error"]("Error permanently delete category!");
            }
        });
    }
}

function restoreCategoryAction() {
    if(restoreCategoryUrl) {
        $.ajax({
            url: restoreCategoryUrl,
            method: "POST",
            data: {
                _token: _csrf
            },
            success: function (response) {
                location.reload();
            },
            error: function (xhr, status, error) {
                toastr["error"]("Error restoring category state!");
            }
        });
    }
}

function viewOrder(id, orderId, url) {
    $.ajax({
        url: url,
        method: "POST",
        data: {
            _token: _csrf,
            id: id,
            order_id: orderId
        },
        success: function (response) {
            $('.order_id_col').text(response.order.order_id);
            $('.amount_col').text(`${response.order.amount} $ ${response.order.currency}`);
            $('.customer_name_col').text(response.order.payer_name);
            $('.customer_email_col').text(response.order.payer_email);
            $('.status_col').text(response.order.status);
            $('.country_col').text(response.order.payer_country);
            $(".updated_date_col").text(formatDateString(new Date(response.order.updated_at)));

            // Render items
            $('.items-container').html(response.items);

            orderModal.modal('show');
        },
        error: function (xhr, status, error) {
            toastr["error"]("Error reading order information! "+error);
        }
    });
}

function formatDateString(date) {
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based
    const year = date.getFullYear();
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');

    return `${day}/${month}/${year} ${hours}:${minutes}`;
}

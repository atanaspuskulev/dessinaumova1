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
let archiveProductUrl;
let destroyProductUrl;
let restoreProductUrl;
let destroyImageUrl;
$(function () {
    $('[data-toggle="tooltip"]').tooltip();

    if ($('.sortable-container').length > 0) {
        $(".sortable-container").sortable({
            items: ".sortable-item",
            cursor: "move",
            update: function (event, ui) {
                let sortedItems = $(this).sortable("toArray");
                $.ajax({
                    url: reorder_gallery_url, // Replace with your actual route
                    method: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
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
            handle: ".card-header", // The header is the handle for dragging
            update: function (event, ui) {
                // This function is called after an item is dropped
                // You can perform any necessary updates here, like sending the new order to the server
                var newOrder = $(this).sortable("toArray");
                console.log(newOrder); // You can send this order to the server via AJAX
            }
        });
    }

    if($('#deleteImage').length > 0) {
        deleteImageModal = $('#deleteImage');
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

function trashProductAction() {
    if(archiveProductUrl) {
        $.ajax({
            url: archiveProductUrl, // Replace with your actual route
            method: "DELETE",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
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
            url: destroyProductUrl, // Replace with your actual route
            method: "DELETE",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
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
            url: destroyImageUrl, // Replace with your actual route
            method: "DELETE",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
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
            url: restoreProductUrl, // Replace with your actual route
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
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

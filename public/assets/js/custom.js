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
let archiveProductUrl;
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

    if($('#deleteImage').length > 0) {
        deleteImageModal = $('#deleteImage');
    }

    if($('#trashProduct').length > 0) {
        trashProductModal = $('#trashProduct');
    }
});

function deleteImage() {
    deleteImageModal.modal('show');
}

function trashProduct(url) {
    trashProductModal.modal('show');
    archiveProductUrl = url;
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
                toastr["error"]("Error saving positioning!");
            }
        });
    }
}

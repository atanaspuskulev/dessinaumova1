<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Desi - Admin</title>
    <link href="{{ asset('assets/css/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/fancybox//jquery.fancybox-1.3.4.css') }}" type="text/css" media="screen" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
</head>

<body id="page-top">
<div id="wrapper">
    @include('partials/sidebar')
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            @include('partials/topbar')
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>

<script src="{{ asset('assets/fancybox/jquery.fancybox-1.3.4.pack.js') }}"></script>
<script>
    var j = jQuery.noConflict();
    j(function() {
       if(j(".gallery_images").length > 0) {
           j(".gallery_images").fancybox();
       }
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script src="{{ asset('assets/css/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

<script>
    $(function() {
        if($('.sortable-container').length > 0) {
            $(".sortable-container").sortable({
                items: ".sortable-item",
                cursor: "move",
                update: function(event, ui) {
                    let sortedItems = $(this).sortable("toArray");
                    $.ajax({
                        url: '{{ route("admin.product.reorder_images") }}', // Replace with your actual route
                        method: "POST",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            product_id: {{ $product->id }},
                            order: sortedItems
                        },
                        success: function(response) {
                            console.log("Order updated successfully!");
                        },
                        error: function(xhr, status, error) {
                            console.error("Error updating order: " + error);
                        }
                    });
                }
            });
        }
    });
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Products Page</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">
</head>


<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Products</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    {{--  <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Products</a>
                    </li> --}}

                </ul>
                {{--  <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form> --}}
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <input type="hidden" name="txt-product-primary-id" value="0" id="txt-product-primary-id">
                <div class="card my-4">

                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title"> Products</h5>
                            </div>

                            <div>
                                <button type="button" class="btn btn-primary btn-sm btn-new-mdl-product-modal"
                                    data-bs-toggle="modal" data-bs-target="#mdl-product-modal">
                                    Add Product
                                </button>
                            </div>
                        </div>
                        <div class="my-4">
                            <table id="products-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            Product name
                                        </th>
                                        <th>
                                            Quantity in stock
                                        </th>
                                        <th>
                                            Price per item
                                        </th>
                                        <th>
                                            Date time submitted
                                        </th>
                                        <th>
                                            Total value number
                                        </th>
                                        <th>
                                            Action
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @if (count($products) > 0)
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>
                                                    {{ $product['name'] }}
                                                </td>
                                                <td>
                                                    {{ $product['quantity'] }}
                                                </td>
                                                <td>
                                                    {{ $product['price'] }}
                                                </td>
                                                <td>
                                                    {{ $product['created_at'] }}
                                                </td>
                                                <td>
                                                    {{ $product['total'] }}
                                                </td>
                                                <td>
                                                    <a href=""
                                                        class="btn btn-edit-mdl-product-modal btn-sm btn-warning"
                                                        data-val="{{ $product['id'] }}">
                                                        Edit
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                No available product
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="mdl-product-modal" tabindex="-1" aria-labelledby="mdl-product-modalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3" id="frm-product-modal">
                            <div id="div-product-modal-error" class="alert alert-danger" role="alert"></div>

                            @csrf
                            <div class="col-md-12">
                                <label for="product_name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="product_name">
                            </div>
                            <div class="col-md-6">
                                <label for="price" class="form-label">Price per Item</label>
                                <input type="text" class="form-control" id="price">
                            </div>
                            <div class="col-md-6">
                                <label for="quantity" class="form-label">Quantity </label>
                                <input type="number" class="form-control" min="0" id="quantity">
                            </div>

                            <label for="colFormLabelSm" class="col-sm-2 form-label col-form-label-sm">Total</label>
                            <div class="col-sm-10">
                                <span id="txt-product-total">0</span>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-save-mdl-product-modal" class="btn btn-primary">

                            <span id="spinner-products" class="spinner-border spinner-border-sm text-light" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </span>

                            Save </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            $(document).on('click', ".btn-new-mdl-product-modal", function(e) {
                $('#div-product-modal-error').hide();
                $('#mdl-product-modal').modal('show');
                $('#frm-product-modal').trigger("reset");
                $('#txt-product-primary-id').val(0);
                $(".modal-title").html('Add Product')

                $('#div-show-txt-product-primary-id').hide();
                $('#div-edit-txt-product-primary-id').show();

                $("#spinner-products").hide();
                $("#div-save-mdl-product-modal").show();
                $("#div-save-mdl-product-modal").attr('disabled', false);
            });


            //Show Modal for Edit
            $(document).on('click', ".btn-edit-mdl-product-modal", function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });
                $(".modal-title").html('Edit Product')
                $('#div-product-modal-error').hide();
                $('#mdl-product-modal').modal('show');
                $('#frm-product-modal').trigger("reset");

                $("#spinner-products").show();
                $("#div-save-mdl-product-modal").attr('disabled', true);

                $('#div-show-txt-product-primary-id').hide();
                $('#div-edit-txt-product-primary-id').show();
                $("#div-save-mdl-product-modal").show();
                let itemId = $(this).attr('data-val');

                $.get("{{ route('products.show', '') }}/" + itemId).done(function(response) {
                    $('#txt-product-primary-id').val(response.data.id)
                    $('#product_name').val(response.data.name);
                    $('#price').val(response.data.price);
                    $('#quantity').val(response.data.quantity);
                    $('#txt-product-total').html(response.data.total);
                    $("#spinner-products").hide();
                    $("#div-save-mdl-product-modal").attr('disabled', false);
                });
            });

            $('#quantity').change(function() {

                let quantity = $('#quantity').val();
                let price = $('#price').val();

                $('#txt-product-total').html(price * quantity)
            })


            //Save details
            $('#btn-save-mdl-product-modal').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });



                $("#spinner-products").show();
                $("#div-save-mdl-product-modal").attr('disabled', true);

                let actionType = "POST";
                let endPointUrl = "{{ route('products.store') }}";
                let primaryId = $('#txt-product-primary-id').val();

                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());

                if (primaryId != "0") {
                    actionType = "PUT";
                    endPointUrl = "{{ route('products.update', '') }}/" + primaryId;
                    formData.append('id', primaryId);
                }

                formData.append('_method', actionType);

                if ($('#product_name').length > 0) {

                    formData.append("name", $('#product_name').val());
                }

                if ($('#price').length > 0) {

                    formData.append("price", $('#price').val());
                }

                if ($('#quantity').length > 0) {

                    formData.append('quantity', $('#quantity').val());
                }





                $.ajax({
                    url: endPointUrl,
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(result) {
                        if (result.errors) {
                            $('#div-product-modal-error').html('');
                            $('#div-product-modal-error').show();

                            $.each(result.errors, function(key, value) {
                                $('#div-product-modal-error').append('<li class="">' +
                                    value + '</li>');
                            });
                        } else {
                            $('#div-product-modal-error').hide();

                            $('#div-product-modal-error').hide();

                            Swal.fire({
                                title: "Saved",
                                text: "product saved successfully",
                                icon: "success"
                            });

                            location.reload(true);
                        }

                        $("#spinner-products").hide();
                        $("#div-save-mdl-product-modal").attr('disabled', false);

                    },
                    error: function(data) {
                        console.log(data);
                        if (data.status == 422) {
                            $('#div-product-modal-error').html('');
                            $('#div-product-modal-error').show();

                            $.each(data.responseJSON.errors, function(key, value) {
                                $('#div-product-modal-error').append('<li class="">' +
                                    value + '</li>');
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Something went wrong!",
                                footer: '<a href="#">Why do I have this issue?</a>'
                            });

                        }

                        $("#spinner-products").hide();
                        $("#div-save-mdl-product-modal").attr('disabled', false);

                    }
                });
            });


        })
    </script>
</body>

</html>

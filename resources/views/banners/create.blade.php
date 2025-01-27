@extends('layouts.app')

@section('content')
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
<style>
ul.chosen-choices {
    width: 477px !important;
}
    </style>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Add Banner</h5>
                                    <div class="float-right">
                                        <a href="{{ route('banners.index') }}" class="btn btn-primary btn-md primary-btn">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('banners.store') }}"  method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="type">Type</label>
                                                <select name="type" id="type" class="form-control">
                                                    <option value="" selected disabled>Select Type</option>
                                                    <option value="main_banner">Main Banner</option>
                                                    <option value="side_banner">Side Banner</option>
                                                    <option value="center_banner">Center Banner</option>
                                                    <option value="banner">Banner</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="product">Product</label>
                                                <input name="product" id="" type="text" class="form-control product-autocomplete"
                                                    value="{{ old('product') }}">
                                                <div class="autocomplete-items"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="menu">Menu</label>
                                                <input type="text" name="menu" class="form-control" value="{{ old('menu') }}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="submenu">Submenu</label>
                                                <input type="text" name="submenu" class="form-control" value="{{ old('submenu') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="add-banner">Banner</label>
                                                <div class="custom-file">
                                                    <input type="file" name="banner" class="custom-file-input" id="add-banner">
                                                    <label class="custom-file-label" for="add-banner">Choose Banner</label>
                                                        <img src="" id="previewImg" height="50" width="50" name="image" hidden>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="size">Size</label>
                                                <select name="size" id="size" class="form-control">
                                                    <option value="" selected disabled>Select size</option>
                                                    <option value="493*400 px">493*400 px</option>
                                                    <option value="250*165 px">250*165 px</option>
                                                    <option value="435*202 px">435*202 px</option>
                                                    <option value="280*547 px">280*547 px</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary primary-btn">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('body').on('input', '.product-autocomplete', function () {
                var input = $(this).val().trim();
                var autocompleteContainer = $(this).siblings('.autocomplete-items');

                $.ajax({
                    type: 'GET',
                    url: '{{ route('product.autocomplete') }}',
                    data: { input: input },
                    success: function (response) {
                        autocompleteContainer.empty();
                        if (response.length > 0) {
                            $.each(response, function (key, value) {
                                var autocompleteItem = '<div class="autocomplete-item" data-id="' + value.id + '">' + value.product_name + '</div>';
                                autocompleteContainer.append(autocompleteItem);
                            });
                            autocompleteContainer.show();
                        } else {
                            autocompleteContainer.hide();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Autocomplete AJAX error:', status, error);
                    }
                });
            });

            $('body').on('click', '.autocomplete-item', function() {
                var productName = $(this).text();
                var productId = $(this).data('id');
                var inputField = $(this).closest('.form-group').find('.product-autocomplete');
                inputField.val(productName);
                $(this).closest('.autocomplete-items').empty().hide();
            });

            $('#add-banner').change(function() {
                var input = this;
                if (input.files && input.files[0]) {
                    $('#previewImg').prop('hidden', false);
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewImg').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });
        });

        $(function() {
            $('form').validate({
                rules: {
                    type:    "required",
                    product: "required",
                    menu:    "required",
                    submenu: "required",
                    banner:  "required",
                    size:    "required"
                },

                messages: {
                    type:    "Please select type",
                    product: "Please enter product",
                    menu:    "Please enter menu",
                    submenu: "Please enter submenu",
                    banner:  "Please enter banner",
                    size:    "Please eneter size"
                },

                errorClass: "text-danger f-12",
                errorElement: "span",
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("form-control-danger");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass("form-control-danger");
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        })
    </script>
@endsection

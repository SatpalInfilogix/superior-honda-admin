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
                                    <h5>Edit Banner</h5>
                                    <div class="float-right">
                                        <a href="{{ route('banners.index') }}" class="btn btn-primary btn-md primary-btn">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('banners.update', $banner->id) }}"  method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="type">Type</label>
                                                <select name="type" id="type" class="form-control">
                                                    <option value="" selected disabled>Select Type</option>
                                                    <option value="main_banner" @selected($banner->type == 'main_banner')>Main Banner</option>
                                                    <option value="side_banner" @selected($banner->type == 'side_banner')>Side Banner</option>
                                                    <option value="center_banner" @selected($banner->type == 'center_banner')>Center Banner</option>
                                                    <option value="banner" @selected($banner->type == 'banner')>Banner</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="product">Product</label>
                                                <input name="product" id="" type="text" class="form-control product-autocomplete"
                                                    value="{{ old('product', $banner->product_name) }}">
                                                <div class="autocomplete-items"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="menu">Menu</label>
                                                <input type="text" name="menu" class="form-control" value="{{ old('menu', $banner->menu) }}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="submenu">Submenu</label>
                                                <input type="text" name="submenu" class="form-control" value="{{ old('submenu', $banner->submenu) }}">
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="add-banner">Banner</label>
                                                <div class="custom-file">
                                                    <input type="file" name="banner" class="custom-file-input" id="add-banner">
                                                    <label class="custom-file-label" for="add-banner">Choose Banner</label>
                                                    <div id="imagePreview">
                                                        @if ($banner->banner_image)
                                                            <img src="{{ asset($banner->banner_image) }}" id="preview-Img" class="img-preview" width="50" height="50">
                                                        @else
                                                            <img src="" id="preview-Img" height="50" width="50" name="image" hidden>
                                                        @endif
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="size">Size</label>
                                                <select name="size" id="size" class="form-control">
                                                    <option value="" selected disabled>Select size</option>
                                                    <option value="493*400 px" @selected($banner->size == '493*400 px')>493*400 px</option>
                                                    <option value="250*165 px" @selected($banner->size == '250*165 px')>250*165 px</option>
                                                    <option value="435*202 px" @selected($banner->size == '435*202 px')>435*202 px</option>
                                                    <option value="280*547 px" @selected($banner->size == '280*547 px')>280*547 px</option>
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
                    url: '{{ route('autocomplete') }}',
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
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').html(
                            '<img class="preview-img" width="50px" height="50px" src="' + e.target
                            .result + '" alt="Selected Image">');
                    }
                    reader.readAsDataURL(file);
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
                    size:    "required"
                },

                messages: {
                    type:    "Please select type",
                    product: "Please enter product",
                    menu:    "Please enter menu",
                    submenu: "Please enter submenu",
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

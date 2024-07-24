@extends('layouts.app')

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Add Products</h5>
                                    <div class="float-right">
                                        <a href="{{ route('products.index') }}" class="btn btn-primary primary-btn btn-md">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="product_code" label="Product Code" value="{{ old('product_code') }}"></x-input-text>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="category_id">Category</label>
                                                <select name="category_id" id="category_id" class="form-control">
                                                    <option value="" selected disabled>Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="product_name" label="Product Name" value="{{ old('product_name') }}"></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="manufacture_name" label="Manufacture Name" value="{{ old('manufacture_name') }}"></x-input-text>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="vehicle_category_id">Vehicle Category</label>
                                                <select name="vehicle_category_id" id="vehicle_category_id" class="form-control">
                                                    <option value="" selected disabled>Select Vehicle Category</option>
                                                    @foreach($vehicleCategories as $vehicleCategory)
                                                        <option value="{{ $vehicleCategory->id }}">{{ $vehicleCategory->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="brand_name" class>Brand Name</label>
                                                <select class="form-control" id="brand_name" name="brand_name">
                                                    <option value="" selected disabled>Select Brand</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="model_name" class>Model Name</label>
                                                <select class="form-control" id="model_name" name="model_name">
                                                    <option value="" selected disabled>Select Model</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="model_variant_name" class>Model Variant Name</label>
                                                <select class="form-control" id="model_variant_name" name="model_variant_name">
                                                    <option value="" selected disabled>Select Model Variant Name</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="model_name" class>Vehicle Type</label>
                                                <select class="form-control" id="vehicle_type" name="vehicle_type">
                                                    <option value="" selected disabled>Select Vehicle Type</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="supplier" label="Supplier" value="{{ old('supplier') }}"></x-input-text>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="cost_price" class>Cost Price</label>
                                                <input type="number" id="price" name="cost_price" class="form-control"value="{{ old('cost_price') }}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="item_number" class>Item Number</label>
                                                <input type="number" id="item_number" name="item_number" class="form-control"value="{{ old('item_number') }}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="model_name" class>Quantity</label>
                                                <input type="number" id="quantity" name="quantity" class="form-control"value="{{ old('quantity') }}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="branch">Description</label>
                                                <textarea id="description" name="description" class="form-control" rows="2" cols="50"></textarea>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2 form-group">
                                                <label for="oem" class>OEM</label>
                                                <input type="checkbox" id="oem" name="oem" value="0" onclick='oemClick(this);'>
                                            </div>
                                        </div>

                                        <div class ="row">
                                            <div class="col-md-2 form-group">
                                                <label for="service" class>Is Service</label>
                                                <input type="checkbox" id="is_service" name="is_service" value="0" onclick='serviceClick(this);'>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="popular" class>Is Popular Product</label>
                                                <input type="checkbox" id="is_popular" name="is_popular" value="0" onclick='popularClick(this);'>
                                            </div>

                                            <div class="col-md-2 form-group">
                                                <label for="service" class>Used Part</label>
                                                <input type="checkbox" id="used_part" name="used_part" value="0" onclick='usedPart(this);'>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="popular" class>Access Series</label>
                                                <input type="checkbox" id="access_series" name="access_series" value="0" onclick='accessSeries(this);'>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for="image" class>Image</label>
                                                <input type="file" name="images[]" id="images" multiple class="form-control" required>
                                                <div id="image_preview_new"></div>
                                            </div>
                                        <div>
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
    <x-include-plugins multipleImage></x-include-plugins>
    <script>
        function oemClick(e) {
            e.value = e.checked ? 1 : 0;
            $('#oem').val(e.value);
        }

        function serviceClick(e) {
            e.value = e.checked ? 1 : 0;
        }

        function popularClick(e) {
            e.value = e.checked ? 1 : 0;
        }
        function usedPart(e) {
            e.value = e.checked ? 1 : 0;
        }
        function accessSeries(e) {
            e.value = e.checked ? 1 : 0;
        }

        $(function() {
            $('form').validate({
                rules: {
                    category_id: "required",
                    product_name: "required",
                    manufacture_name: "required",
                },
                messages: {
                    category_id: "Please enter category name",
                    product_name: "Please enter product name",
                    manufacture_name: "Please enter manufacture name",

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

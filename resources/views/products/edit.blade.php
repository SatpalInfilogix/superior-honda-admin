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
                                    <h5>Edit Product</h5>
                                    <div class="float-right">
                                        <a href="{{ route('products.index') }}" class="btn btn-primary primary-btn btn-md">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <form action="{{ route('products.update',$product->id) }}" method="POST"  enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="product_code" label="Product Code" value="{{ old('product_code', $product->product_code) }}"></x-input-text>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="category_id">Category</label>
                                                <select name="category_id" id="category_id" class="form-control">
                                                    <option value="" selected disabled>Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" @selected($product->category_id == $category->id)>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="product_name" label="Product Name" value="{{ old('product_name', $product->product_name) }}"></x-input-text>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <x-input-text name="manufacture_name" label="Manufacture Name" value="{{ old('manufacture_name', $product->manufacture_name) }}"></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                            <label for="vehicle_category_id">Vehicle Category</label>
                                            <select name="vehicle_category_id" id="vehicle_category_id" class="form-control">
                                                <option value="" selected disabled>Select Vehicle Category</option>
                                                @foreach($vehicleCategories as $vehicleCategory)
                                                    <option value="{{ $vehicleCategory->id }}" @selected($product->vehicle_category_id == $vehicleCategory->id)>{{ $vehicleCategory->name }}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="brand_name" class>Brand Name</label>
                                                <select class="form-control" id="brand_name" name="brand_name" placeholder="Select Brand">
                                                    <option value="" selected disabled>Select Brand</option>
                                                   @if($brands)
                                                        @foreach($brands as $brand)
                                                            <option value="{{$brand->id}}" @selected($product->brand_id == $brand->id)>{{ $brand->brand_name }}</option>
                                                        @endforeach
                                                   @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="model" class>Model Name</label>
                                                <select class="form-control" id="model_name" name="model_name">
                                                    <option value="" selected disabled>Select Model</option>
                                                    @if($vehicleModels)
                                                        @foreach($vehicleModels as $vehicleModel)
                                                            <option value="{{$vehicleModel->id}}" @selected($product->model_id == $vehicleModel->id)>{{ $vehicleModel->model_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="model_variant_name" class>Model Variant Name</label>
                                                <select class="form-control" id="model_variant_name" name="model_variant_name">
                                                    <option value="" selected disabled>Select Model Variant Name</option>
                                                    @if($modelVariants)
                                                    @foreach($modelVariants as $modelVariants)
                                                        <option value="{{$modelVariants->id}}" @selected($product->varient_model_id == $modelVariants->id)>{{ $modelVariants->variant_name }}</option>
                                                    @endforeach
                                                @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="model_name" class>Vehicle Type</label>
                                                <select class="form-control" id="vehicle_type" name="vehicle_type">
                                                    <option value="" selected disabled>Select Vehicle Type</option>
                                                    @if($vehicleTypes)
                                                    @foreach($vehicleTypes as $vehicleType)
                                                        <option value="{{$vehicleType->id}}" @selected($product->type_id == $vehicleType->id)>{{ $vehicleType->vehicle_type }}</option>
                                                    @endforeach
                                                @endif
                                                </select>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <x-input-text name="supplier" label="Supplier" value="{{ old('supplier', $product->supplier) }}"></x-input-text>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="cost_price" class>Cost Price</label>
                                                <input type="number" id="price" name="cost_price" class="form-control"value="{{ old('cost_price', $product->cost_price) }}">
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="item_number" class>Item Number</label>
                                                <input type="number" id="item_number" name="item_number" class="form-control"value="{{ old('item_number', $product->item_number) }}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="model_name" class>Quantity</label>
                                                <input type="number" id="quantity" name="quantity" class="form-control"value="{{ old('quantity', $product->quantity) }}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="branch">Description</label>
                                                <textarea id="description" name="description" class="form-control" rows="2" cols="50">{{ $product->description }}</textarea>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2 form-group">
                                                <label for="oem" class>OEM</label>
                                                <input type="checkbox" id="oem" name="oem" value="{{ $product->is_oem }}" @checked($product->is_oem == 1) onclick='oemClick(this);'>
                                            </div>
                                        </div>

                                        <div class ="row">
                                            <div class="col-md-2 form-group">
                                                <label for="service" class>Is Service</label>
                                                <input type="checkbox" id="is_service" name="is_service" value="{{ $product->is_service }}" @checked($product->is_service == 1) onclick='serviceClick(this);'>
                                             </div>
                                            <div class="col-md-4 form-group">
                                                <label for="popular" class>Is Popular Product</label>
                                                <input type="checkbox" id="is_popular" name="is_popular" value="{{ $product->popular }}" @checked($product->popular == 1) onclick='popularClick(this);'>
                                           </div>
                                           <div class="col-md-2 form-group">
                                                <label for="popular" class>Used Part</label>
                                                <input type="checkbox" id="used_part" name="used_part" value="{{ $product->used_part }}" @checked($product->used_part == 1) onclick='popularClick(this);'>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="popular" class>Access Series</label>
                                                <input type="checkbox" id="access_series" name="access_series" value="{{ $product->access_series }}" @checked($product->access_series == 1)  onclick='accessSeries(this);'>
                                            </div>
                                        </div>

                                        <div class="position-relative form-group">
                                            <label for="inputLastname" class="">Image</label>
                                            <input type="file" name="images[]" id="images" accept="image/*" multiple class="form-control mb-1">
                                        </div>
                        
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <div id="image_preview" class="row">
                                                    @foreach ($product->images as $key => $image)
                                                        <div class="existing-img-div img-div" id="existing-img-div{{ $image->id }}">
                                                            <img src="{{ asset($image->images) }}" id="previewImg-{{ $image->id }}" style="height:141px; width:150px;" name="image" class="img-responsive image">
                                                            <div class='middle'>
                                                                <a href ="javascript:void(0)" class="btn btn-danger delete-image image-delete-{{ $image->id }}" data-id="{{ $image->id }}" id="delete-image"><i class="fas fa-trash"></i></a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <span id="image_preview_new"></span>
                                                </div>
                                            </div>
                                            <input type ="hidden" name="image_id[]" id ="image_id">
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
    <x-include-plugins multipleImage></x-include-plugins>

    <script>
        let deletedImageId= [];
        $('.delete-image').on('click', function() {
            var imageId = $(this).data('id');
            deletedImageId.push(imageId);
            $('#previewImg-' + imageId).prop('hidden', true)
            $('.image-delete-' + imageId).prop('hidden', true)
            $('#existing-img-div' + imageId).prop('hidden', true)
            $('#image_id').val(deletedImageId);
        });

        function oemClick(e) {
            e.value = e.checked ? 1 : 0;
            $('#oem').val(e.value);
        }

        function serviceClick(e) {
            e.value = e.checked ? 1 : 0;
            $('#is_service').val(e.value);
        }

        function popularClick(e) {
            e.value = e.checked ? 1 : 0;
            $('#is_popular').val(e.value);
        }

        function usedPart(e) {
            e.value = e.checked ? 1 : 0;
            $('#used_part').val(e.value);
        }

        function accessSeries(e) {
            e.value = e.checked ? 1 : 0;
            $('#access_series').val(e.value);
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

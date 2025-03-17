@extends('layouts.app')

@section('content')
<style>
    span.ui-selectmenu-text {
    display: none;
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
                                        <!-- <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="parent_category_id">Parent Category <span style="color: red;">*</span></label>
                                                <select id="parent_category_id" name="parent_category_id[]" class="form-control chosen-select" multiple="multiple">
                                                    @php
                                                        $selected_categories = [];
                                                    @endphp    
                                                    @foreach($product->parent_categories as $parent_category)
                                                        @php
                                                            array_push($selected_categories, $parent_category->parent_category_name);
                                                        @endphp
                                                    @endforeach
                                                        <option value="select_all">Select All</option>
                                                        <option value="product" {{ in_array('product', $selected_categories) ? 'selected' : '' }}>Product</option>
                                                        <option value="service" {{ in_array('service', $selected_categories) ? 'selected' : '' }}>Service</option>
                                                        <option value="accessories" {{ in_array('accessories', $selected_categories) ? 'selected' : '' }}>Accessories</option>
                                                </select>
                                                <span class="form-control-danger" id="parent_category_id_error" style="display:none; color: #dc3545; font-size:12px;">Please select atleast 1 category.</span>
                                            </div>
                                        </div> -->

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="product_code">Product Code <span style="color: red;">*</span></label>
                                                <input class="form-control" id="product_code" name="product_code" label="Product Code"
                                                    value="{{ old('product_code', $product->product_code) }}"/>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="category_id">Category <span style="color: red;">*</span></label>
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
                                                <x-input-text name="product_name" label="Product Name" value="{{ old('product_name', $product->product_name) }}" required="true"></x-input-text>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <x-input-text name="manufacture_name" label="Manufacture Name" value="{{ old('manufacture_name', $product->manufacture_name) }}" required="true"></x-input-text>
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
                                                <label for="year">Year</label>
                                                <select id="year_range" name="year_range[]" class="form-control chosen-select" multiple="multiple">
                                                    <option value="select_all">Select All</option>
                                                    @foreach(range(date('Y'),1950) as $year)
                                                        <option value="{{ $year }}" 
                                                            @if(in_array($year, old('year_range', $selectedYears))) selected @endif>
                                                            {{ $year }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <input type="checkbox" id="oem" name="oem" value="{{ $product->is_oem }}" @checked($product->is_oem == 1) onclick='oemClick(this);'>
                                                <label for="oem" class>OEM</label>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <input type="checkbox" id="out_of_stock" name="out_of_stock" value="{{ $product->out_of_stock }}" @checked($product->out_of_stock == 1) onclick='outOfStock(this);'>
                                                <label for="out_of_stock" class>Out Of Stock</label>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <input type="checkbox" id="is_popular" name="is_popular" value="{{ $product->popular }}" @checked($product->popular == 1) onclick='popularClick(this);'>
                                                <label for="is_popular" class>Is Popular Product</label>
                                           </div>
                                           <div class="col-md-3 form-group">
                                               <input type="checkbox" id="used_part" name="used_part" value="{{ $product->used_part }}" @checked($product->used_part == 1) onclick='usedPart(this);'>
                                                <label for="used_part" class>Used Part</label>
                                            </div>
                                        </div>

                                        <div class ="row">
                                            <div class="col-md-3 form-group">
                                                <input type="checkbox" id="access_series" name="access_series" value="{{ $product->access_series }}" @checked($product->access_series == 1)  onclick='accessSeries(this);'>
                                                <label for="access_series" class>Accesseries</label>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <input type="checkbox" id="is_service" name="is_service" value="{{ $product->is_service }}" @checked($product->is_service == 1) onclick='serviceClick(this);'>
                                                <label for="is_service" class>Is Service</label>
                                             </div>
                                        </div>

                                          <div id="serviceFields" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="add-icon">Service Icon</label>
                                                    <div class="custom-file">
                                                        <input type="file" name="service_icon" class="custom-file-input" id="add-icon">
                                                        <label class="custom-file-label" for="add-icon">Choose Service Icon</label>
                                                        <div id="iconPreview">
                                                            @if ($product->service_icon)
                                                                <img src="{{ asset($product->service_icon) }}" id="preview-icon" class="icon-preview" width="50" height="50">
                                                            @else
                                                                <img src="" id="preview-icon" height="50" width="50" name="image" hidden>
                                                            @endif
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="short_description" class>Short Description</label>
                                                    <textarea id="short_description" name="short_description" class="form-control" rows="2" cols="50">{{ old('short_description', $product->short_description) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for="branch">Description</label>
                                                <textarea id="editor" name="description" class="form-control" rows="2" cols="50">{{ old('description', $product->description) }}</textarea>
                                            </div>
                                        </div>

                                        <div class="position-relative form-group">
                                            <label for="inputLastname" class="">Image <span style="color: red;">*</span></label>
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
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
         $(document).ready(function() {
            CKEDITOR.replace('editor');
            var startYear = 1950;
            var endYear = new Date().getFullYear();

            var yearDropdown = $('#year_range');
            for (var year = endYear; year >= startYear; year--) {
                yearDropdown.append($('<option>', {
                    value: year,
                    text: year
                }));
            }

            $(".chosen-select").chosen({
                width: '100%',
                no_results_text: "Oops, nothing found!"
            })

            $('#year_range').selectmenu();
        });


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
            $('#serviceFields').toggle(e.checked);
            if (e.checked) {
                $('#access_series').prop('checked', false).val(0); 
            }
        }

        $(document).ready(function() {
            serviceClick(document.getElementById('is_service'));
        });

        function popularClick(e) {
            e.value = e.checked ? 1 : 0;
            $('#is_popular').val(e.value);
        }

        function outOfStock(e) {
            e.value = e.checked ? 1 : 0;
            $('#out_of_stock').val(e.value);
        }

        function usedPart(e) {
            e.value = e.checked ? 1 : 0;
            $('#used_part').val(e.value);
        }

        function accessSeries(e) {
            e.value = e.checked ? 1 : 0;
            $('#access_series').val(e.value);
            if (e.checked) {
                $('#is_service').prop('checked', false).val(0); // Uncheck and set value to 0
                $('#serviceFields').hide();
            }
        }

        $(function() {
            $('form').validate({
                rules: {
                    product_code: "required",
                    category_id: "required",
                    product_name: "required",
                    manufacture_name: "required",
                    vehicle_category_id: "required",
                    short_description: {
                        required: function() {
                            return $('#is_service').is(':checked');
                        }
                    },
                },
                messages: {
                    product_code: "Please enter product code",
                    category_id: "Please enter category name",
                    product_name: "Please enter product name",
                    manufacture_name: "Please enter manufacture name",
                    vehicle_category_id: "Please enter vehicle category",
                    short_description: "Please enter a short description",
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
            $('#add-icon').change(function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#iconPreview').html(
                            '<img class="preview-img" width="50px" height="50px" src="' + e.target
                            .result + '" alt="Selected Image">');
                    }
                    reader.readAsDataURL(file);
                }
            });
        })
    </script>
@endsection

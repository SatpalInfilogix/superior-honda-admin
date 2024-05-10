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
                                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-md">
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
                                                <x-input-text name="product_name" label="Product Name" value="{{ old('product_name', $product->product_name) }}"></x-input-text>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <x-input-text name="manufacture_name" label="Manufacture Name" value="{{ old('manufacture_name', $product->manufacture_name) }}"></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                            <label for="category_id">Category</label>
                                            <select name="category_id" id="category_id" class="form-control">
                                                <option value="" selected disabled>Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" @selected($product->category_id == $category->id)>{{ $category->name }}</option>
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
                                                <label for="" class>Quantity</label>
                                                <input type="number" id="quantity" name="quantity" class="form-control"value="{{ old('quantity',$product->quantity) }}">
                                            </div>

                                            <div class="col-md-3 form-group">
                                                <label for="oem" class>OEM</label>
                                                <input type="checkbox" id="oem" name="oem" value="{{ $product->is_oem }}" @checked($product->is_oem == 1) onclick='oemClick(this);'>
                                            </div>

                                            <div class="col-md-3 form-group">
                                                <label for="service" class>Service</label>
                                                <input type="checkbox" id="is_service" name="is_service" value="{{ $product->is_service }}" @checked($product->is_service == 1) onclick='serviceClick(this);'>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Save</button>
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
        function oemClick(e) {
            e.value = e.checked ? 1 : 0;
            $('#oem').val(e.value);
        }

        function serviceClick(e) {
            e.value = e.checked ? 1 : 0;
            $('#is_service').val(e.value);
        }
        $(function() {
            $('#category_id').on('change', function() {
                var category_id = this.value;
                $("#brand_name").html('');
                $("#vehicle_type").html('');
                $.ajax({
                    url: "{{ url('get-vehicle-brand') }}",
                    type: "POST",
                    data: {
                        category_id: category_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#brand_name').html(result.options);
                        $("#vehicle_type").html(result.vehicleTypeOption);
                    }
                });
            });

            $('#brand_name').on('change', function() {
                var brand_id = this.value;
                $("#model_name").html('');
                $.ajax({
                    url: "{{ url('get-vehicle-model') }}",
                    type: "POST",
                    data: {
                        brand_id: brand_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#model_name').html(result.options);
                    }
                });
            });

            $('#model_name').on('change', function() {
                var model_id = this.value;
                console.log(model_id); 
                $("#model_variant_name").html('');
                $.ajax({
                    url: "{{ url('get-vehicle-model-variant') }}",
                    type: "POST",
                    data: {
                        model_id: model_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#model_variant_name').html(result.options);
                    }
                });
            });

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

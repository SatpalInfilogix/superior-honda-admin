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
                                    <h5>Edit Vehicle</h5>
                                    <div class="float-right">
                                        <a href="{{ route('vehicles.index') }}" class="btn btn-primary primary-btn btn-md">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <form action="{{ route('vehicles.update',$vehicle->id) }}" method="POST"  enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="customer_id">Customer</label>
                                                <select name="customer_id" id="customer_id" class="form-control">
                                                    <option value="" selected disabled>Select Customer</option>
                                                    @foreach($customers as $customer)
                                                        <option value="{{ $customer->id }}" @selected($vehicle->cus_id == $customer->id)>{{ $customer->first_name.' '. $customer->last_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="category_id">Category</label>
                                                <select name="category_id" id="category_id" class="form-control">
                                                    <option value="" selected disabled>Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" @selected($vehicle->category_id == $category->id)>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="brand_name" class>Brand Name</label>
                                                <select class="form-control" id="brand_name" name="brand_name" placeholder="Select Brand">
                                                    <option value="" selected disabled>Select Brand</option>
                                                   @if($brands)
                                                        @foreach($brands as $brand)
                                                            <option value="{{$brand->id}}" @selected($vehicle->brand_id == $brand->id)>{{ $brand->brand_name }}</option>
                                                        @endforeach
                                                   @endif
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="model" class>Model Name</label>
                                                <select class="form-control" id="model_name" name="model_name">
                                                    <option value="" selected disabled>Select Model</option>
                                                    @if($vehicleModels)
                                                        @foreach($vehicleModels as $vehicleModel)
                                                            <option value="{{$vehicleModel->id}}" @selected($vehicle->model_id == $vehicleModel->id)>{{ $vehicleModel->model_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="model_variant_name" class>Model Variant Name</label>
                                                <select class="form-control" id="model_variant_name" name="model_variant_name">
                                                    <option value="" selected disabled>Select Model Variant Name</option>
                                                    @if($modelVariants)
                                                        @foreach($modelVariants as $modelVariants)
                                                            <option value="{{$modelVariants->id}}" @selected($vehicle->varient_model_id == $modelVariants->id)>{{ $modelVariants->variant_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="model_name" class>Vehicle Type</label>
                                                <select class="form-control" id="vehicle_type" name="vehicle_type">
                                                    <option value="" selected disabled>Select Vehicle Type</option>
                                                    @if($vehicleTypes)
                                                        @foreach($vehicleTypes as $vehicleType)
                                                            <option value="{{$vehicleType->id}}" @selected($vehicle->type_id == $vehicleType->id)>{{ $vehicleType->vehicle_type }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="vehicle_no" label="Vehicle No" value="{{ old('vehicle_no', $vehicle->vehicle_no) }}"></x-input-text>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <x-input-text name="year" label="Year" value="{{ old('year', $vehicle->year) }}"></x-input-text>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="color" label="Color" value="{{ old('color', $vehicle->color) }}"></x-input-text>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <x-input-text name="chasis_no" label="Chasis No" value="{{ old('chasis_no', $vehicle->chasis_no) }}"></x-input-text>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="engine_no" label="Engine No" value="{{ old('engine_no', $vehicle->engine_no) }}"></x-input-text>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="branch">Additional Detail</label>
                                                <textarea id="additional_detail" name="additional_detail" class="form-control" rows="2" cols="50">{{ $vehicle->additional_details }}</textarea>
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
                    category_id:    "required",
                    customer_id:    "required",
                    year:           "required",
                    vehicle_no:     "required",
                    vehicle_type:   "required"
                },
                messages: {
                    customer_id: "Please enter customer name",
                    category_id: "Please enter category name",
                    year:        "Please enter year",
                    vehicle_no:  "please enter vehicle number",
                    vehicle_type: "Please enter vehicle type"
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

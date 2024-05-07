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
                                    <h5>Add Vehicle Model Variant</h5>
                                    <div class="float-right">
                                        <a href="{{ route('vehicle-model-variants.index') }}" class="btn btn-primary btn-md">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <form action="{{ route('vehicle-model-variants.store') }}" method="POST"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                            <label for="category_id">Category</label>
                                            <select name="category_id" id="category_id" class="form-control">
                                                <option value="" selected disabled>Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                                                <label for="model_name" class>Vehicle Type</label>
                                                <select class="form-control" id="vehicle_type" name="vehicle_type">
                                                    <option value="" selected disabled>Select Vehicle Type</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="variant_name" label="Variant Name" value="{{ old('variant_name') }}"></x-input-text>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <x-input-text name="fuel_type" label="Fuel Type" value="{{ old('fuel_type') }}"></x-input-text>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="add-car-model">Model Variant Image</label>
                                            <div class="custom-file">
                                                <input type="file" name="model_variant_image" class="custom-file-input" id="add-model-variant-image">
                                                <label class="custom-file-label" for="add-model-variant-image">Choose Car Image</label>
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
                console.log(brand_id); 
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

            $('form').validate({
                rules: {
                    category_id: "required",
                    variant_name: "required",
                    fuel_type: "required",
                    model_variant_image: "required"
                },
                messages: {
                    category_id: "Please enter category name",
                    variant_name: "Please enter variant name",
                    fuel_type: "Please enter fuel type",
                    model_variant_image: "Model Image field is required"

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

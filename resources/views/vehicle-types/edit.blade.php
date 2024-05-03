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
                                    <h5>Edit Vehicle Type</h5>
                                    <div class="float-right">
                                        <a href="{{ route('vehicle-types.index') }}" class="btn btn-primary btn-md">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('vehicle-types.update', $vehicleType->id) }}" method="POST" name="edit-vehicle-type">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="category_id">Select Category</label>
                                            <select name="category_id" id="category_id" class="form-control">
                                                <option value="" disabled>Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" @selected($vehicleType->category_id ==  $category->id) >{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <x-input-text name="vehicle_type" label="Vehicle Type" value="{{ old('vehicle_type', $vehicleType->vehicle_type) }}"></x-input-text>
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
            $('[name="edit-vehicle-type"]').validate({
            rules: {
                vehicle_type: "required"
            },
            messages: {
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

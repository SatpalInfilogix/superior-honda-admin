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
                                    <h5>Add Vehicle Brand</h5>
                                    <div class="float-right">
                                        <a href="{{ route('vehicle-brands.index') }}" class="btn btn-primary primary-btn btn-md">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('vehicle-brands.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="category_id">Select Category</label>
                                            <select name="category_id" id="category_id" class="form-control">
                                                @foreach($vehicleCategories as $vehicleCategory)
                                                    <option value="{{ $vehicleCategory->id }}">{{ $vehicleCategory->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <x-input-text name="brand_name" label="Brand Name" value="{{ old('brand_name') }}"></x-input-text>
                                        </div>
                                        <div class="form-group">
                                            <label for="add-brand-logo">Brand Logo</label>
                                            <div class="custom-file">
                                                <input type="file" name="brand_logo" class="custom-file-input" id="add-brand-logo">
                                                <label class="custom-file-label" for="add-brand-logo">Choose Brand Logo</label>
                                            </div>
                                            <img src="" id="image_preview" height="50"width="50" name="image" hidden>
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
        $(function() {
            $('#add-brand-logo').change(function() {
                var input = this;
                if (input.files && input.files[0]) {
                    $('#image_preview').prop('hidden', false);
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image_preview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });

            $('form').validate({
                rules: {
                    category_id: "required",
                    brand_name: "required",
                    brand_logo: "required"
                },
                messages: {
                    category_id: "Please enter category name",
                    brand_name: "Please enter brand name",
                    brand_logo: "Please choose brand logo"
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

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
                                    <h5>Add Vehicle Model</h5>
                                    <div class="float-right">
                                        <a href="{{ route('vehicle-models.index') }}" class="btn btn-primary btn-md">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <form action="{{ route('vehicle-models.store') }}" method="POST"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="category_id">Category</label>
                                            <select name="category_id" id="category_id" class="form-control">
                                                <option value="" selected disabled>Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="brand_name" class>Brand Name</label>
                                            <select class="form-control" id="brand_name" name="brand_name">
                                                <option value="" selected disabled>Select Brand</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <x-input-text name="model_name" label="Model Name" value="{{ old('model_name') }}"></x-input-text>
                                        </div>

                                        <div class="form-group">
                                            <label for="add-car-model">Car Image</label>
                                            <div class="custom-file">
                                                <input type="file" name="model_image" class="custom-file-input" id="add-model-image">
                                                <label class="custom-file-label" for="add-car-image">Choose Car Image</label>
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
                        $('#category_length').val(result.length);
                    }
                });
            });

            $('form').validate({
                rules: {
                    category_id: "required",
                    model_name: "required",
                    model_image: "required"
                },
                messages: {
                    category_id: "Please enter category name",
                    model_name: "Please enter model name",
                    model_image: "Model Image field is required"

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

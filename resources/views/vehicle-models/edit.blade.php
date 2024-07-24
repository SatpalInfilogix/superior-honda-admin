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
                                    <h5>Edit Vehicle Model</h5>
                                    <div class="float-right">
                                        <a href="{{ route('vehicle-models.index') }}" class="btn btn-primary primary-btn btn-md">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('vehicle-models.update', $vehicleModel->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="category_id">Select Category</label>
                                            <select name="category_id" id="category" class="form-control">
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" @selected($vehicleModel->category_id == $category->id)>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="brand_name" class>Brand Name</label>
                                            <select class="form-control" id="brand_name" name="brand_name" placeholder="Select Brand">
                                                <option value="" selected disabled>Select Brand</option>
                                               @if($brands)
                                                    @foreach($brands as $brand)
                                                        <option value="{{$brand->id}}"  {{ $vehicleModel->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                                                    @endforeach
                                               @endif
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <x-input-text name="model_name" label="Model Name" value="{{ old('model_name', $vehicleModel->model_name ) }}"></x-input-text>
                                        </div>
                                        <div class="form-group">
                                            <label for="add-model-image">Model Image</label>
                                            <div class="custom-file">
                                                <input type="file" name="model_image" class="custom-file-input" id="add-model-image">
                                                <label class="custom-file-label" for="add-model-image">Choose Model Image</label>
                                            </div>
                                            <div id="imagePreview">
                                                @if ($vehicleModel->model_image)
                                                    <img src="{{ asset($vehicleModel->model_image) }}" id="preview-Img" class="img-preview" width="50" height="50">
                                                @else
                                                    <img src="" id="preview-Img" height="50" width="50" name="image" hidden>
                                                @endif
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
        $(document).ready(function() {
            $('#add-model-image').change(function() {
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
            $('#category').on('change', function() {
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
                    }
                });
            });

            $('form').validate({
                rules: {
                    category_id: "required",
                    model_name: "required",
                },
                messages: {
                    category_id: "Please enter category name",
                    model_name: "Please enter model name",
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

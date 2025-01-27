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
                                    <h5>Add Product Category</h5>
                                    <div class="float-right">
                                        <a href="{{ route('product-categories.index') }}" class="btn btn-primary primary-btn btn-md">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <form action="{{ route('product-categories.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <x-input-text name="name" label="Category Name" value="{{ old('name') }}"></x-input-text>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for="image" class>Image</label>
                                                <input type="file" name="image" class="form-control" required id="add-category-image">
                                                <img src="" id="image_preview" height="50"width="50" name="image" hidden>
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
    <x-include-plugins imagePreview></x-include-plugins>
    
    <script>
        $(function() {
            $('form').validate({
                rules: {
                    name: "required"
                },
                messages: {
                    name: "Please enter category name"
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

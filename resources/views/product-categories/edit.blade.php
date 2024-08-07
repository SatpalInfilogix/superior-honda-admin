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
                                    <h5>Edit Product Category</h5>
                                    <div class="float-right">
                                        <a href="{{ route('product-categories.index') }}" class="btn btn-primary primary-btn btn-md">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <form action="{{ route('product-categories.update', $product_category->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <x-input-text name="name" label="Category Name" value="{{ old('name', $product_category->name) }}"></x-input-text>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for="image" class>Image</label>
                                                <input type="file" name="image" id="add-category-image" class="form-control">
                                                <div id="imagePreview">
                                                @if ($product_category->category_image)
                                                    <img src="{{ asset($product_category->category_image) }}" id="preview-Img" class="img-preview" width="50" height="50">
                                                @else
                                                    <img src="" id="preview-Img" height="50" width="50" name="image" hidden>
                                                @endif
                                            </div>
                                                <!-- <div id="image_preview"><img src="{{ asset($product_category->category_image) }}"></div> -->
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
            $('#add-category-image').change(function() {
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
        </script>
@endsection
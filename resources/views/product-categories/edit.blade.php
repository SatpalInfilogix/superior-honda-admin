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
                                            <label for="category-name">Category Name</label>
                                            <input type="text" class="form-control" name="name" id="category-name" value="{{ $product_category->name }}">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for="image" class>Image</label>
                                                <input type="file" name="image" id="imageInput" class="form-control" required>
                                                <div id="image_preview"><img src="{{ asset($product_category->category_image) }}"></div>
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
    <x-include-plugins imagePreview></x-include-plugins>
@endsection
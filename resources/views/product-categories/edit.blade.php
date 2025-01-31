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

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="parent_category_id">Parent Category</label>
                                                <select id="parent_category_id" name="parent_category_id[]" class="form-control chosen-select" multiple="multiple">
                                                    @php
                                                        $selected_categories = [];
                                                    @endphp    
                                                    @foreach($product_category->parent_categories as $parent_category)
                                                        @php
                                                            array_push($selected_categories, $parent_category->parent_category_name);
                                                        @endphp
                                                    @endforeach
                                                        <option value="product" {{ in_array('product', $selected_categories) ? 'selected' : '' }}>Product</option>
                                                        <option value="service" {{ in_array('service', $selected_categories) ? 'selected' : '' }}>Service</option>
                                                        <option value="accessories" {{ in_array('accessories', $selected_categories) ? 'selected' : '' }}>Accessories</option>
                                                </select>
                                                <span class="form-control-danger" id="parent_category_id_error" style="display:none; color: #dc3545; font-size:12px;">Please select atleast 1 category.</span>
                                            </div>
                                        </div>

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

            $(".chosen-select").chosen({
                width: '100%',
                no_results_text: "Oops, nothing found!"
            })
        });
        </script>
@endsection
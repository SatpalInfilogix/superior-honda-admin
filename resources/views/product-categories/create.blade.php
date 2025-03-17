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

                                        <div class="row">
                                            <div class="col-md-5 form-group">
                                                <label for="parent_category_id">Parent Category <span style="color: red;">*</span></label>
                                                <select id="parent_category_id" name="parent_category_id[]" class="form-control chosen-select" multiple="multiple">
                                                <option value="select_all">Select All</option>
                                                    <option value="product">Product</option>
                                                    <option value="service">Service</option>
                                                    <option value="accessories">Accessories</option>
                                                </select>
                                                <span class="form-control-danger" id="parent_category_id_error" style="display:none; color: #dc3545; font-size:12px;">Please select atleast 1 category.</span>
                                            </div>

                                            <div class="form-group col-md-7">
                                                <label for="name">Category Name <span style="color: red;">*</span></label>
                                                <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}"/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for="image" class>Image <span style="color: red;">*</span></label>
                                                <input type="file" name="image" class="form-control" required id="add-category-image">
                                                <img src="" id="image_preview" height="50"width="50" name="image" hidden>
                                            </div>
                                        <div>
                                        <button type="submit" class="btn btn-primary primary-btn" id="submit_btn">Save</button>
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

            $(document).ready(function() {
                $('#parent_category_id').change(function() {
                    if ($(this).val().length === 0) {
                        $('#parent_category_id_error').css('display', 'block');
                        return false;
                    }else{
                        $('#parent_category_id_error').css('display', 'none');
                    }
                });
                
                $('#submit_btn').on('click', function() {
                    if ($('#parent_category_id').val().length === 0) {
                        $('#parent_category_id_error').css('display', 'block');
                        return false;
                    }else{
                        $('#parent_category_id_error').css('display', 'none');
                    }
                });
            });

            $(".chosen-select").chosen({
                width: '100%',
                no_results_text: "Oops, nothing found!"
            })
        })
    </script>
@endsection

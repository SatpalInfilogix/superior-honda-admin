@extends('layouts.app')

@section('content')
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
<style>
    div#week_status_chosen {
        width: 423px !important;
    }
    .chosen-container { 
        width: 100% !important;
    }
</style>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Edit Promotion</h5>
                                    <div class="float-right">
                                        <a href="{{ route('promotions.index') }}" class="btn btn-primary primary-btn btn-md">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('promotions.update', $promotion->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="heading" label="Heading" value="{{ old('heading', $promotion->heading) }}" required></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="main_image" class>Main Image <span style="color: red;">*</span></label>
                                                <input type="file" name="main_image" id="main_image" class="form-control" accept="image/*">
                                                <div id="promotionImagePreview">
                                                    @if ($promotion->main_image)
                                                        <img src="{{ asset($promotion->main_image) }}" id="promotion-main-img-preview" class="icon-preview" width="100" height="100">
                                                    @else
                                                        <img src="" id="promotion-main-img-preview" height="100" width="100" name="image" hidden>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">                                            
                                            <div class="col-md-6 form-group">
                                                <label for="promotion_product_id">Products <span style="color: red;">*</span></label>
                                                <select name="promotion_product_id[]" id="promotion_product_id" class="form-control chosen-select" multiple="multiple">
                                                <option value="select_all">Select All</option>
                                                    @php
                                                        $product_ids = $promotion->promotion_products->pluck('product_id');
                                                    @endphp
                                                    @if(!empty($products))                                                    
                                                        @foreach ($products as $key => $product)
                                                            <option value="{{$product->id}}" @selected( in_array($product->id, $product_ids->toArray()) )>{{ $product->product_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <span class="form-control-danger" id="promotion_product_id_error" style="display:none; color: #dc3545; font-size:12px;">Please select atleast 1 product.</span>
                                            </div>                           
                                            <div class="col-md-6 form-group">
                                                <label for="promotion_service_id">Services <span style="color: red;">*</span></label>
                                                <select name="promotion_service_id[]" id="promotion_service_id" class="form-control chosen-select" multiple="multiple">
                                                <option value="select_all">Select All</option>
                                                    @php
                                                        $service_ids = $promotion->promotion_services->pluck('service_id');
                                                    @endphp
                                                    @if(!empty($services))
                                                        @foreach ($services as $key => $service)
                                                            <option value="{{$service->id}}" @selected( in_array($service->id, $service_ids->toArray()) )>{{ $service->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <span class="form-control-danger" id="promotion_service_id_error" style="display:none; color: #dc3545; font-size:12px;">Please select atleast 1 service.</span>
                                            </div>
                                        </div>
                                        <div class="row">                          
                                            <div class="col-md-12 form-group">
                                                <label for="image" class>Images <span style="color: red;">*</span></label>
                                                <input type="file" name="images[]" id="images" multiple class="form-control" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <div id="image_preview" class="row">
                                                    @foreach ($promotion->promotion_images as $key => $image)
                                                        <div class="existing-img-div img-div" id="existing-img-div{{ $image->id }}">
                                                            <img src="{{ asset($image->image) }}" id="previewImg-{{ $image->id }}" style="height:141px; width:150px;" name="image" class="img-responsive image">
                                                            <div class='middle'>
                                                                <a href ="javascript:void(0)" class="btn btn-danger delete-image image-delete-{{ $image->id }}" data-id="{{ $image->id }}" id="delete-image"><i class="fas fa-trash"></i></a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <span id="image_preview_new"></span>
                                                </div>
                                            </div>
                                            <input type ="hidden" name="image_id[]" id ="image_id">
                                        </div>
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
    <x-include-plugins multipleImage></x-include-plugins>

    <script>
        $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!"
        })
        $(function() {
            $('form').validate({
                rules: {
                    heading: "required",
                    "promotion_product_id[]": "required",
                    "promotion_service_id[]": "required",
                },
                messages: {
                    heading: "Please enter promotion heading",
                    "promotion_product_id[]": "Please select at least one product.",
                    "promotion_service_id[]": "Please select at least one service.",
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

            $('#location_image').change(function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#locationImagePreview').html(
                            '<img class="location-preview-icon" width="100px" height="100px" src="' + e.target
                            .result + '" alt="Selected Image">');
                    }
                    reader.readAsDataURL(file);
                }
            });

            let deletedImageId= [];
            $('.delete-image').on('click', function() {
                var imageId = $(this).data('id');
                deletedImageId.push(imageId);
                $('#previewImg-' + imageId).prop('hidden', true)
                $('.image-delete-' + imageId).prop('hidden', true)
                $('#existing-img-div' + imageId).prop('hidden', true)
                $('#image_id').val(deletedImageId);
            });

            $('#main_image').change(function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#promotionImagePreview').html(
                            '<img class="promotion-main-img-preview" width="100px" height="100px" src="' + e.target
                            .result + '" alt="Selected Image">');
                    }
                    reader.readAsDataURL(file);
                }
            });
        });

        $(document).ready(function(){
            $('#promotion_product_id').change(function() {
                if ($(this).val().length === 0) {
                    $('#promotion_product_id_error').css('display', 'block');
                }else{
                    $('#promotion_product_id_error').css('display', 'none');
                }
            });

            $('#promotion_service_id').change(function() {
                if ($(this).val().length === 0) {
                    $('#promotion_service_id_error').css('display', 'block');
                }else{
                    $('#promotion_service_id_error').css('display', 'none');
                }
            });
            
            $('#submit_btn').on('click', function() {
                if ($('#promotion_product_id').val().length === 0) {
                    $('#promotion_product_id_error').css('display', 'block');
                }else{
                    $('#promotion_product_id_error').css('display', 'none');
                }

                if ($('#promotion_service_id').val().length === 0) {
                    $('#promotion_service_id_error').css('display', 'block');
                }else{
                    $('#promotion_service_id_error').css('display', 'none');
                }
            });
        });
    </script>
@endsection

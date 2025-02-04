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
                                    <h5>Add Promotion</h5>
                                    <div class="float-right">
                                        <a href="{{ route('promotions.index') }}" class="btn btn-primary btn-md primary-btn">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('promotions.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="heading" label="Heading" value="{{ old('heading') }}"></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="main_image" class>Main Image</label>
                                                <input type="file" name="main_image" id="main_image" class="form-control" accept="image/*">
                                                <img src="" id="previewPromotionImage" height="100" width="100" name="icon" hidden>
                                            </div>
                                        </div>
                                        <div class="row">                                            
                                            <div class="col-md-6 form-group">
                                                <label for="promotion_product_id">Products</label>
                                                <select name="promotion_product_id[]" id="promotion_product_id" class="form-control chosen-select" multiple="multiple">
                                                    <option value="" disabled>Select Products</option>
                                                    @if(!empty($products))
                                                        @foreach ($products as $key => $product)
                                                            <option value="{{$product->id}}">{{ $product->product_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <span class="form-control-danger" id="promotion_product_id_error" style="display:none; color: #dc3545; font-size:12px;">Please select atleast 1 product.</span>
                                            </div>                           
                                            <div class="col-md-6 form-group">
                                                <label for="promotion_service_id">Services</label>
                                                <select name="promotion_service_id[]" id="promotion_service_id" class="form-control chosen-select" multiple="multiple">
                                                    <option value="" disabled>Select Services</option>
                                                    @if(!empty($services))
                                                        @foreach ($services as $key => $service)
                                                            <option value="{{$service->id}}">{{ $service->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <span class="form-control-danger" id="promotion_service_id_error" style="display:none; color: #dc3545; font-size:12px;">Please select atleast 1 service.</span>
                                            </div>
                                        </div>
                                        <div class="row">                          
                                            <div class="col-md-12 form-group">
                                                <label for="image" class>Images</label>
                                                <input type="file" name="images[]" id="images" multiple class="form-control" accept="image/*">
                                                <div id="image_preview_new"></div>
                                            </div>
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
        $(document).ready(function() {
            $(".chosen-select").chosen({
                no_results_text: "Oops, nothing found!"
            });
        });

        $(function() {
            $('form').validate({
                rules: {
                    heading: "required",
                    main_image: "required",
                    "promotion_product_id[]": "required",
                    "promotion_service_id[]": "required",
                    "images[]": "required",
                },
                messages: {
                    heading: "Please enter promotion heading",
                    main_image: "Please select a image",
                    "promotion_product_id[]": "Please select at least one product.",
                    "promotion_service_id[]": "Please select at least one service.",
                    "images[]": "Please select images.",
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

            $('#main_image').change(function() {
                var input = this;
                if (input.files && input.files[0]) {
                    $('#previewPromotionImage').prop('hidden', false);
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewPromotionImage').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
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

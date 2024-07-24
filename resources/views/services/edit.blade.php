@extends('layouts.app')

@section('content')
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
<style>
ul.chosen-choices {
    width: 477px !important;
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
                                    <h5>Edit Service</h5>
                                    <div class="float-right">
                                        <a href="{{ route('services.index') }}" class="btn btn-primary btn-md primary-btn">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('services.update', $service->id) }}"  method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="type">Name</label>
                                                <input type="text" name="name" value="{{ old('name', $service->name) }}" class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="product">Price</label>
                                                <input name="price" id="price" type="text" class="form-control" value="{{ old('price', $service->price) }}">
                                            </div>
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="type">Manufacture name</label>
                                                <input type="text" name="manufacture_name" class="form-control " value="{{ old('manufacture_name', $service->manufacture_name) }}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="model">Model Name</label>
                                                <input name="model" id="" type="text" class="form-control model-autocomplete"
                                                    value="{{ old('model', $service->model_name) }}">
                                                <div class="autocomplete-items"></div>
                                            </div>
                                        </div> -->
                                        <!-- <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="menu">Start Date</label>
                                                <input type="text" name="start_date"  id="datepicker" class="form-control" value="{{ old('start_date', $service->start_date) }}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="submenu">End Date</label>
                                                <input type="text" name="end_date"  id="datepicke" class="form-control" value="{{ old('end_date', $service->end_date) }}">
                                            </div>
                                        </div> -->
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="add-icon">Service Icon</label>
                                                <div class="custom-file">
                                                    <input type="file" name="icon" class="custom-file-input" id="add-icon">
                                                    <label class="custom-file-label" for="add-icon">Choose Service Icon</label>
                                                    <div id="iconPreview">
                                                        @if ($service->service_icon)
                                                            <img src="{{ asset($service->service_icon) }}" id="preview-icon" class="icon-preview" width="50" height="50">
                                                        @else
                                                            <img src="" id="preview-icon" height="50" width="50" name="image" hidden>
                                                        @endif
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="add-image">Image</label>
                                                <div class="custom-file">
                                                    <input type="file" name="image" class="custom-file-input" id="add-image">
                                                    <label class="custom-file-label" for="add-banner">Choose Image</label>
                                                    <div id="imagePreview">
                                                        @if ($service->image)
                                                            <img src="{{ asset($service->image) }}" id="preview-Img" class="img-preview" width="50" height="50">
                                                        @else
                                                            <img src="" id="preview-Img" height="50" width="50" name="image" hidden>
                                                        @endif
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="branch">Short Description</label>
                                                <textarea id="short_description" name="short_description" class="form-control" rows="2" cols="50">{{$service->short_description}}</textarea>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="branch">Description</label>
                                                <textarea id="description" name="description" class="form-control" rows="2" cols="50">{{$service->description}}</textarea>
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
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>

    <script>
         document.addEventListener('DOMContentLoaded', function () {
            ClassicEditor
                .create(document.querySelector('#description'))
                .catch(error => {
                    console.error(error);
                });
        });
        $(document).ready(function () {
            // $('#datepicker').datepicker();
            // $('#datepicke').datepicker();
            $('#add-image').change(function() {
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

            $('#add-icon').change(function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#iconPreview').html(
                            '<img class="preview-img" width="50px" height="50px" src="' + e.target
                            .result + '" alt="Selected Image">');
                    }
                    reader.readAsDataURL(file);
                }
            });

            $('body').on('input', '.model-autocomplete', function () {
                var input = $(this).val().trim();
                var autocompleteContainer = $(this).siblings('.autocomplete-items');

                $.ajax({
                    type: 'GET',
                    url: '{{ route('autocomplete-model') }}',
                    data: { input: input },
                    success: function (response) {
                        autocompleteContainer.empty();
                        if (response.length > 0) {
                            $.each(response, function (key, value) {
                                var autocompleteItem = '<div class="autocomplete-item" data-id="' + value.id + '">' + value.model_name + '</div>';
                                autocompleteContainer.append(autocompleteItem);
                            });
                            autocompleteContainer.show();
                        } else {
                            autocompleteContainer.hide();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Autocomplete AJAX error:', status, error);
                    }
                });
            });

            $('body').on('click', '.autocomplete-item', function() {
                var productName = $(this).text();
                var productId = $(this).data('id');
                var inputField = $(this).closest('.form-group').find('.model-autocomplete');
                inputField.val(productName);
                $(this).closest('.autocomplete-items').empty().hide();
            });

            $('#add-image').change(function() {
                var input = this;
                if (input.files && input.files[0]) {
                    $('#previewImg').prop('hidden', false);
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewImg').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });
        });

        $(function() {
            $('form').validate({
                rules: {
                    name: "required",
                    price: "required",
                    // manufacture_name: "required",
                    // start_date: "required",
                    // end_date: "required",
                    // model: "required",
                    description: "required",
                },

                messages: {
                    name: "Please enter name",
                    price: "Please enter price",
                    // manufacture_name: "Please enter manufacture name",
                    // start_date: "Please enter start date",
                    // end_date:  "Please enter end date",
                    // model: "Please enter model",
                    description: "Please enter description",
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

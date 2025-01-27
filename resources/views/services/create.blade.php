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
                                    <h5>Add Service</h5>
                                    <div class="float-right">
                                        <a href="{{ route('services.index') }}" class="btn btn-primary btn-md primary-btn">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('services.store') }}"  method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="type">Service Number</label>
                                                <input type="text" name="service_no" value="{{ old('service_no') }}" class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="type">Name</label>
                                                <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                                            </div>
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="type">Manufacture name</label>
                                                <input type="text" name="manufacture_name" class="form-control " value="{{ old('manufacture_name') }}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="model">Model Name</label>
                                                <input name="model" id="" type="text" class="form-control model-autocomplete"
                                                    value="{{ old('model') }}">
                                                <div class="autocomplete-items"></div>
                                            </div>
                                        </div> -->
                                        <!-- <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="menu">Start Date</label>
                                                <input type="text" name="start_date" id="datepicker" class="form-control" value="{{ old('start_date') }}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="submenu">End Date</label>
                                                <input type="text" name="end_date" id="datepicke" class="form-control" value="{{ old('end_date') }}">
                                            </div>
                                        </div> -->
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="product">Price</label>
                                                <input name="price" id="price" type="number" class="form-control" value="{{ old('price') }}">
                                            </div>
                                            {{-- <div class="col-md-6 form-group">
                                                <label for="add-icon">Service Icon</label>
                                                <div class="custom-file">
                                                    <input type="file" name="icon" class="custom-file-input" id="add-icon">
                                                    <label class="custom-file-label" for="add-icon">Choose Icon</label>
                                                    <img src="" id="previewIcon" height="50" width="50" name="icon" hidden>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="add-image">Image</label>
                                                <div class="custom-file">
                                                    <input type="file" name="image" class="custom-file-input" id="add-image">
                                                    <label class="custom-file-label" for="add-image">Choose Image</label>
                                                        <img src="" id="previewImg" height="50" width="50" name="image" hidden>
                                                </div>
                                            </div> --}}
                                           
                                        </div>
                                        {{-- <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="branch">Short Description</label>
                                                <textarea id="short_description" name="short_description" class="form-control" rows="2" cols="50"></textarea>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="branch">Long Description</label>
                                                <textarea id="description" name="description" class="form-control" rows="2" cols="50"></textarea>
                                            </div>
                                        </div> --}}
                                        
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

            $('#add-icon').change(function() {
                var input = this;
                if (input.files && input.files[0]) {
                    $('#previewIcon').prop('hidden', false);
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewIcon').attr('src', e.target.result);
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
                    short_description: "required",
                    description: "required",
                    icon: "required",
                    image : "required"
                },

                messages: {
                    name: "Please enter name",
                    price: "Please enter price",
                    // manufacture_name: "Please enter manufacture name",
                    // start_date: "Please enter start date",
                    // end_date:  "Please enter end date",
                    // model: "Please enter model",
                    short_description: "Please enter short description",
                    description: "Please enter description",
                    icon: "Please select service icon",
                    image : "Please enter image"
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

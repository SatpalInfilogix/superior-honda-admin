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
                                    <h5>Add Testimonial</h5>
                                    <div class="float-right">
                                        <a href="{{ route('testimonials.index') }}" class="btn btn-primary btn-md primary-btn">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('testimonials.store') }}"  method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="type">Name</label>
                                                <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="type">Designation</label>
                                                <input type="text" name="designation" value="{{ old('designation') }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="add-image">Image</label>
                                                <div class="custom-file">
                                                    <input type="file" name="image" class="custom-file-input" id="add-image">
                                                    <label class="custom-file-label" for="add-image">Choose Image</label>
                                                        <img src="" id="previewImg" height="50" width="50" name="image" hidden>
                                                </div>
                                            </div> 
                                           
                                            <div class="col-md-6 form-group">
                                                <label for="branch">Heading</label>
                                                <input id="heading" name="heading" class="form-control" value="{{ old('heading') }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="branch">Feedback</label>
                                                <textarea id="feedback" name="feedback" class="form-control" rows="3" cols="50"></textarea>
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
                .create(document.querySelector('#feedback'))
                .catch(error => {
                    console.error(error);
                });
        });

        $(function() {
            $('form').validate({
                rules: {
                    name: "required",
                    designation: "required",
                    heading: "required",
                    feedback: "required",
                },

                messages: {
                    name: "Please enter name",
                    designation: "Please enter designation",
                    heading: "Please enter heading",
                    feedback: "Please enter feedback",
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

        $(document).ready(function () {
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
    </script>
@endsection

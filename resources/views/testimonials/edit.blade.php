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
                                    <h5>Edit Testimonial</h5>
                                    <div class="float-right">
                                        <a href="{{ route('testimonials.index') }}" class="btn btn-primary btn-md primary-btn">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('testimonials.update', $testimonial->id) }}"  method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="type">Name</label>
                                                <input type="text" name="name" value="{{ old('name', $testimonial->name) }}" class="form-control" placeholder="Enter Name">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="type">Designation</label>
                                                <input type="text" name="designation" value="{{ old('designation', $testimonial->designation) }}" class="form-control" placeholder="Enter Designation">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="add-image">Image</label>
                                                <div class="custom-file">
                                                    <input type="file" name="image" class="custom-file-input" id="add-image">
                                                    <label class="custom-file-label" for="add-banner">Choose Image</label>
                                                    <div id="imagePreview">
                                                        @if ($testimonial->image)
                                                            <img src="{{ asset($testimonial->image) }}" id="preview-Img" class="img-preview" width="50" height="50">
                                                        @else
                                                            <img src="" id="preview-Img" height="50" width="50" name="image" hidden>
                                                        @endif
                                                        </div>
                                                </div>
                                            </div>
                                           
                                            <div class="col-md-6 form-group">
                                                <label for="branch">Heading</label>
                                                <input id="heading" name="heading" class="form-control" value="{{ old('heading', $testimonial->heading) }}" placeholder="Heading">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="branch">Feedback</label>
                                                <textarea id="feedback" name="feedback" class="form-control" rows="3" cols="50">{{$testimonial->feedback}}</textarea>
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

        $(document).ready(function () {
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
    </script>
@endsection

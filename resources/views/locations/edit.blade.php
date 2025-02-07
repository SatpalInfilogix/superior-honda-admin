@extends('layouts.app')

@section('content')
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
<style>
    div#week_status_chosen {
        width: 423px !important;
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
                                    <h5>Edit Location</h5>
                                    <div class="float-right">
                                        <a href="{{ route('locations.index') }}" class="btn btn-primary primary-btn btn-md">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('locations.update', $location->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="name" label="Name" value="{{ old('name', $location->name) }}" required></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="image" class>Location Image <span style="color: red;">*</span></label>
                                                <input type="file" name="location_image" id="location_image" class="form-control" accept="image/*">
                                                <div id="locationImagePreview">
                                                    @if ($location->location_image)
                                                        <img src="{{ asset($location->location_image) }}" id="location-preview-icon" class="icon-preview" width="100" height="100">
                                                    @else
                                                        <img src="" id="location-preview-icon" height="100" width="100" name="image" hidden>
                                                    @endif
                                                </div>
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
        $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!"
        })
        $(function() {
            $('form').validate({
                rules: {
                    name: "required",
                },
                messages: {
                    name: "Please enter location name",
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
        })
    </script>
@endsection

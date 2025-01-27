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
                                    <h5>Edit Email</h5>
                                    <div class="float-right">
                                        <a href="{{ route('emails.index') }}" class="btn btn-primary primary-btn btn-md">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('emails.update', $email->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="template" label="Template Name" value="{{ old('template', $email->email_template) }}"></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="status">Status</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="" selected disabled>Select status</option>
                                                    <option value="Active" @selected($email->status == 'Active')>Active</option>
                                                    <option value="Deactive" @selected($email->status == 'Deactive')>Deactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for="branch">Content</label>
                                                <textarea class="form-control" name="content" id="content" rows="2" cols="50" name="body">{{$email->content}}</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="status" class="font-weight-bold">Description</label>
                                                <div class="p-3 rounded bg-light">
                                                    <span class="text-muted">{{$email->description}}</span>
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
    <x-include-plugins textEditor></x-include-plugins>
    <script>
        ClassicEditor.create( document.querySelector( '#content' ) )
        .catch( error => {
            console.error( error );
        });

        $(function() {
            $('form').validate({
                rules: {
                    template_name:"required"
                },
                messages: {
                    template_name: "Please enter template name",
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

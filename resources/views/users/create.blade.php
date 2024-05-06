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
                                    <h5>Add User</h5>
                                    <div class="float-right">
                                        <a href="{{ route('users.index') }}" class="btn btn-primary btn-md">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <x-input-text name="first_name" label="First Name" value="{{ old('first_name') }}"></x-input-text>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <x-input-text name="last_name" label="Last Name" value="{{ old('last_name') }}"></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="email" label="Email Address" value="{{ old('email') }}" ></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <x-input-text name="designation" label="Designation" value="{{ old('designation') }}" ></x-input-text>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label for="role">Role</label>
                                                <select name="role" id="role" class="form-control">
                                                    @foreach ($roles as $key => $role)
                                                        <option value="{{$role->name}}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="dob">Date of Birth</label>
                                                <input type="text" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}" placeholder="YYYY-MM-DD">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="branch">Branch</label>
                                                <select name="branch" id="branch" class="form-control">
                                                    @foreach ($branches as $key => $branch)
                                                        <option value="{{$branch->id}}">{{ $branch->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save</button>
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
        $(function() {
            $('form').validate({
                rules: {
                    first_name: "required",
                    last_name: "required",
                    designation: "required",
                    email:"required"
                },
                messages: {
                    first_name: "Please enter first name",
                    last_name: "Please enter last name",
                    designation: "Please enter designation",
                    email: "Please enter email",
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

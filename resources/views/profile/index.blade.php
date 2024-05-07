@extends('layouts.app')

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="row">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Profile</h5>
                                </div>
                                <div class="card-block">
                                    <form action="{{ route('profile.update', Auth::id()) }}" method="post" enctype="multipart/form-data" id='update-profile'>
                                        @method('patch')
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <x-input-text name="first_name" label="First Name" value="{{ old('first_name', $user->first_name) }}"></x-input-text>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <x-input-text name="last_name" label="Last Name" value="{{ old('last_name', $user->last_name) }}"></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="email" label="Email Address" value="{{ old('email', $user->email) }}" readonly></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="employee_id" label="Emp ID" value="{{ old('employee_id', $user->emp_id) }}" readonly></x-input-text>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="profile-picture">Profile Picture</label>
                                                <div class="custom-file">
                                                    <input type="file" name="profile_image" value="{{ old('profile_image') }}" class="custom-file-input" id="profile-picture">
                                                    <label class="custom-file-label" for="profile-picture">Choose Image</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <x-input-text name="designation" label="Designation" value="{{ old('designation') }}" readonly></x-input-text>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label for="role">Role</label>
                                                <select name="role" id="role" class="form-control" disabled>
                                                    @foreach ($roles as $key => $role)
                                                        <option value="{{$role->id}}" @selected( Auth::user()->roles->pluck('name')[0] == $role->name)>{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="dob">Date of Birth</label>
                                                <input type="text" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $user->date_of_birth ) }}" placeholder="YYYY-MM-DD">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="password" label="Password" value="{{ old('password') }}" ></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="confirm_password" label="Confirm Password" value="{{ old('confirm_password') }}" ></x-input-text>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <button type="submit" class="btn btn-primary">Update Profile</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script>
        $(function() {
        $("#update-profile").validate({
            rules: {
                first_name: "required",
                last_name: "required",
                date_of_birth: "required",
                confirm_password: {
                    equalTo: "#password"
                }
            },
            messages: {
                first_name: "Please enter your firstname",
                last_name: "Please enter your lastname",
                date_of_birth: "Please enter your date of birth",
                confirm_password: {
                    required: 'Please enter confirm password.',
                    equalTo: 'Confirm Password do not match with password.',
                }
            },

            errorClass: "text-danger f-12",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).addClass("form-control-danger");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass("form-control-danger");
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>
@endsection

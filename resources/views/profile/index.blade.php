@extends('layouts.app')

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="row">
                        <div class="col-sm-12">
                            @if (session('message'))
                                <x-alert message="{{ session('message') }}"></x-alert>
                            @endif

                            <div class="card">
                                <div class="card-header">
                                    <h5>Profile</h5>
                                </div>
                                <div class="card-block">
                                    <form action="{{ route('profile.update', Auth::id()) }}" method="post"
                                        enctype="multipart/form-data" id='update-profile'>
                                        @method('patch')
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <x-input-text name="first_name" label="First Name"
                                                    value="{{ old('first_name', $user->first_name) }}"></x-input-text>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <x-input-text name="last_name" label="Last Name"
                                                    value="{{ old('last_name', $user->last_name) }}"></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="email" label="Email Address"
                                                    value="{{ old('email', $user->email) }}" readonly></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="employee_id" label="Emp ID"
                                                    value="{{ old('employee_id', $user->emp_id) }}" readonly></x-input-text>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <div class="row image-preview">
                                                    <div class="col-md-10 form-group">
                                                    <label for="profile-picture">Profile Picture</label>
                                                    <div class="custom-file">
                                                        <input type="file" name="profile_image"
                                                            value="{{ old('profile_image') }}" class="custom-file-input"
                                                            id="profile-picture" id="imageInput" accept="image/*">
                                                        <label class="custom-file-label" for="profile-picture">Choose
                                                            Image</label>
                                                    </div>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <div id="imagePreview">
                                                            @if(!$user->profile_picture)
                                                                <img class="preview-img" width="50px" height="50px" src="{{ asset('assets/images/user-default.png') }}" alt="Selected Image">
                                                            @else
                                                                <img class="preview-img" width="50px" height="50px" src="{{ asset($user->profile_picture) }}" alt="Selected Image">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <x-input-text name="designation" label="Designation"
                                                    value="{{ old('designation') }}" readonly></x-input-text>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label for="role">Role</label>
                                                <select name="role" id="role" class="form-control" disabled>
                                                    @foreach ($roles as $key => $role)
                                                        <option value="{{ $role->id }}" @selected(Auth::user()->roles->pluck('name')[0] == $role->name)>
                                                            {{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="dob">Date of Birth</label>
                                                    <input id="dropper-default" name="date_of_birth" class="form-control"
                                                    value="{{ old('date_of_birth', $user->date_of_birth) }}" type="text" placeholder="Select your date" />    
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="password" label="Password"
                                                    value="{{ old('password') }}"></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="confirm_password" label="Confirm Password"
                                                    value="{{ old('confirm_password') }}"></x-input-text>
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
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
        $(document).ready(function(){
            $('#profile-picture').change(function(){
                var file = this.files[0];
                if(file){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#imagePreview').html('<img class="preview-img" width="50px" height="50px" src="' + e.target.result + '" alt="Selected Image">');
                }
                reader.readAsDataURL(file);
                }
            });
        });
        $("#dropper-default").dateDropper({ dropWidth: 200, dropPrimaryColor: "#1abc9c", dropBorder: "1px solid #1abc9c" }),
        $("#dropper-animation").dateDropper({ dropWidth: 200, init_animation: "bounce", dropPrimaryColor: "#1abc9c", dropBorder: "1px solid #1abc9c" }),
        $("#dropper-format").dateDropper({ dropWidth: 200, format: "F S, Y", dropPrimaryColor: "#1abc9c", dropBorder: "1px solid #1abc9c" }),
        $("#dropper-lang").dateDropper({ dropWidth: 200, format: "F S, Y", dropPrimaryColor: "#1abc9c", dropBorder: "1px solid #1abc9c", lang: "ar" }),
        $("#dropper-lock").dateDropper({ dropWidth: 200, format: "F S, Y", dropPrimaryColor: "#1abc9c", dropBorder: "1px solid #1abc9c", lock: "from" }),
        $("#dropper-max-year").dateDropper({ dropWidth: 200, dropPrimaryColor: "#1abc9c", dropBorder: "1px solid #1abc9c", maxYear: "2020" }),
        $("#dropper-min-year").dateDropper({ dropWidth: 200, dropPrimaryColor: "#1abc9c", dropBorder: "1px solid #1abc9c", minYear: "1990" }),
        $("#year-range").dateDropper({ dropWidth: 200, dropPrimaryColor: "#1abc9c", dropBorder: "1px solid #1abc9c", yearsRange: "5" }),
        $("#dropper-width").dateDropper({ dropPrimaryColor: "#1abc9c", dropBorder: "1px solid #1abc9c", dropWidth: 500 }),
        $("#dropper-dangercolor").dateDropper({ dropWidth: 200, dropPrimaryColor: "#e74c3c", dropBorder: "1px solid #e74c3c" }),
        $("#dropper-backcolor").dateDropper({ dropWidth: 200, dropPrimaryColor: "#1abc9c", dropBorder: "1px solid #1abc9c", dropBackgroundColor: "#bdc3c7" }),
        $("#dropper-txtcolor").dateDropper({ dropWidth: 200, dropPrimaryColor: "#46627f", dropBorder: "1px solid #46627f", dropTextColor: "#FFF", dropBackgroundColor: "#e74c3c" }),
        $("#dropper-radius").dateDropper({ dropWidth: 200, dropPrimaryColor: "#1abc9c", dropBorder: "1px solid #1abc9c", dropBorderRadius: "0" }),
        $("#dropper-border").dateDropper({ dropWidth: 200, dropPrimaryColor: "#1abc9c", dropBorder: "2px solid #1abc9c" }),
        $("#dropper-shadow").dateDropper({ dropWidth: 200, dropPrimaryColor: "#1abc9c", dropBorder: "1px solid #1abc9c", dropBorderRadius: "20px", dropShadow: "0 0 20px 0 rgba(26, 188, 156, 0.6)" });
    </script>
@endsection

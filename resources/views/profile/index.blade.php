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
                                    <h5>Profile</h5>
                                </div>
                                <div class="card-block">
                                    <form action="{{ route('profile.update', Auth::id()) }}" method="post" enctype="multipart/form-data" id='update-profile'>
                                        @method('patch')
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <label for="first-name">First Name</label>
                                                <input type="text" name="first_name" class="form-control" value="{{ old('first-name', $user->first_name) }}">
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label for="last-name">Last Name</label>
                                                <input type="text" name="last_name" class="form-control" value="{{ old('last-name', $user->last_name) }}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="email-address">Email Address</label>
                                                <input type="email" name="email" class="form-control" value="{{ ($user->email) }}" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="employee-id">Emp ID</label>
                                                <input type="text" name="employee_id" class="form-control"  value="{{ ($user->emp_id) }}" readonly>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="profile-picture">Profile Picture</label>
                                                <div class="custom-file">
                                                    <input type="file" name="profile_image" value="{{ old('profile_image') }}" class="custom-file-input" id="profile-picture">
                                                    <label class="custom-file-label" for="profile-picture">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <label for="designation">Designation</label>
                                                <input type="text" name="designation" class="form-control">
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label for="role">Role</label>
                                                @php $roles =['Super Admin', 'Admin', 'Customer Service', 'Accountant', 'Inspection Manager', 'Technician'] @endphp
                                                <select name="role" id="role" class="form-control" disabled>
                                                    @foreach ($roles as $key => $role)
                                                        <option value="{{$role}}" @selected($user->role == $role)>{{ $role }}</option>
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
                                                <label for="password">Password</label>
                                                <input type="text" name="password" id="password" class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="confirm-password">Confirm Password</label>
                                                <input type="text" name="confirm_password" class="form-control">
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

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
                                        <a href="{{ route('users.index') }}" class="btn btn-primary primary-btn btn-md">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <x-input-text name="first_name" label="First Name" value="{{ old('first_name') }}"></x-input-text>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <x-input-text name="last_name" label="Last Name" value="{{ old('last_name') }}"></x-input-text>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <x-input-text name="email" label="Email Address" value="{{ old('email') }}" ></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="designation">Designation</label>
                                                <select name="designation" id="designation" class="form-control">
                                                    <option value="" selected disabled>Select Designation</option>
                                                    @foreach($designations as $designation)
                                                        <option value="{{ $designation }}">{{ $designation }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="role">Role</label>
                                                <select name="role" id="role" class="form-control">
                                                    <option value="" selected disabled>Select Role</option>
                                                    @foreach ($roles as $key => $role)
                                                        <option value="{{$role->name}}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="dob">Date of Birth</label>
                                                <input type="text" name="date_of_birth" class="form-control" id="datepicker" value="{{ old('date_of_birth') }}" placeholder="YYYY-MM-DD">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="branch">Branch</label>
                                                <select name="branch" id="branch" class="form-control">
                                                    <option value="" selected disabled>Select Branch</option>
                                                    @foreach ($branches as $key => $branch)
                                                        <option value="{{$branch->id}}">{{ $branch->name }} @if (strtolower($branch->name) === 'kingston') 🚩 @endif</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="password">Password</label>
                                                <div class="input-group mb-0">
                                                    <input type="password" id="password" name="password" class="form-control">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text primary-btn">
                                                            <i id="togglePassword" class="fas fa-eye"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <label for="password" class="error"></label> <!-- Error message will appear here -->
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="parent_category_id">Category</label>
                                                <select name="parent_category_id[]" id="parent_category_id" class="form-control chosen-select" multiple="multiple">
                                                    <option value="" disabled>Select Category</option>
                                                    <option value="product">Products</option>
                                                    <option value="service">Services</option>
                                                    <option value="accessories">Accessories</option>
                                                </select>
                                                <span class="form-control-danger" id="parent_category_id_error" style="display:none; color: #dc3545; font-size:12px;">Please select atleast 1 category.</span>
                                            </div>
                                        </div>
                                        <div class="row">                                            
                                            <div class="col-md-12 form-group">
                                                <label for="branch">Additional Detail</label>
                                                <textarea id="additional_detail" name="additional_detail" class="form-control" rows="2" cols="50"></textarea>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary primary-btn" id="submit_btn">Save</button>
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
            $('#datepicker').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd' 
            });

            $('form').validate({
                rules: {
                    first_name: "required",
                    last_name: "required",
                    designation: "required",
                    email: "required",
                    role: "required",
                    password: "required"
                },
                messages: {
                    first_name: "Please enter first name",
                    last_name: "Please enter last name",
                    designation: "Please enter designation",
                    email: "Please enter email",
                    role: "Please enter role",
                    password: "Please enter password"
                },
                errorClass: "text-danger",
                errorElement: "label",
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("form-control-danger"); // Highlight input
                    $(element).siblings('label.error').show(); // Show error label
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass("form-control-danger"); // Remove highlight
                    $(element).siblings('label.error').hide(); // Hide error label
                },
                errorPlacement: function(error, element) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent()); // Place error message after input-group
                    } else {
                        error.insertAfter(element); // Default placement
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });

            $('#togglePassword').on('click', function() {
                const passwordField = $('#password');
                const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                passwordField.attr('type', type);
                $(this).toggleClass('fa-eye fa-eye-slash');
            });

            $(document).ready(function() {
                $('#parent_category_id').change(function() {
                    if ($(this).val().length === 0) {
                        $('#parent_category_id_error').css('display', 'block');
                    }else{
                        $('#parent_category_id_error').css('display', 'none');
                    }
                });
                
                $('#submit_btn').on('click', function() {
                    if ($('#parent_category_id').val().length === 0) {
                        $('#parent_category_id_error').css('display', 'block');
                    }else{
                        $('#parent_category_id_error').css('display', 'none');
                    }
                });
            });

            $(".chosen-select").chosen({
                width: '100%',
                no_results_text: "Oops, nothing found!"
            });
        })
    </script>
@endsection

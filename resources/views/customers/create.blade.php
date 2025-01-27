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
                                    <h5>Add Customer</h5>
                                    <div class="float-right">
                                        <a href="{{ route('customers.index') }}" class="btn btn-primary btn-md primary-btn">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="customer_no" label="Customer Number" value="{{ old('customer_no') }}" ></x-input-text>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <x-input-text name="first_name" label="First Name" value="{{ old('first_name') }}"></x-input-text>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <x-input-text name="last_name" label="Last Name" value="{{ old('last_name') }}"></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="address" label="Address" value="{{ old('address') }}" ></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="email" label="Email Address" value="{{ old('email') }}" ></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="phone_number" label="Phone Number" value="{{ old('phone_number') }}" ></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="phone_lime" label="Phone (Lime)" value="{{ old('phone_lime') }}" ></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="dob">Date of Birth</label>
                                                <input type="text" name="date_of_birth" class="form-control m-0" id="datepicker" value="{{ old('date_of_birth') }}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="licence_no" label="Licence Number" value="{{ old('licence_no') }}" ></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="company_info" label="Company Info" value="{{ old('company_info') }}" ></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="city" label="City" value="{{ old('city') }}" ></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="info" label="Info" value="{{ old('info') }}" ></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
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
        $(function() {
            $('#datepicker').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd' 
            });
            $('form').validate({
                rules: {
                    first_name: "required",
                    email: "required",
                    phone_number: "required",
                    address: "required",
                    password: "required",
                    customer_no: "required"
                },
                messages: {
                    first_name: "Please enter first name",
                    email: "Please enter email",
                    phone_number: "Please enter phone number",
                    address: "Please enter address",
                    password: "Please enter password",
                    customer_no: "Please enter customer number."

                },
                errorClass: "text-danger f-12",
                errorElement: "label", // Changed to label for better control
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("form-control-danger");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass("form-control-danger");
                },
                errorPlacement: function(error, element) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent()); // Place error after the input-group
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
        })
    </script>
@endsection

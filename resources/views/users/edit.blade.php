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
                                    <h5>Edit User</h5>
                                    <div class="float-right">
                                        <a href="{{ route('users.index') }}" class="btn btn-primary primary-btn btn-md">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <x-input-text name="first_name" label="First Name" value="{{ old('first_name', $user->first_name) }}" required></x-input-text>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <x-input-text name="last_name" label="Last Name" value="{{ old('last_name', $user->last_name) }}" required></x-input-text>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <x-input-text name="email" label="Email Address" value="{{ old('email', $user->email) }}" readonly></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="designation">Designation <span style="color: red;">*</span></label>
                                                <select name="designation" id="designation" class="form-control" disabled>
                                                    <option value="" selected disabled>Select Designation</option>
                                                    @foreach($designations as $designation)
                                                        <option value="{{ $designation }}" @selected($user->designation == $designation)>{{ $designation }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-4 form-group">
                                                <label for="role">Role <span style="color: red;">*</span></label>
                                                <select name="role" id="role" class="form-control" disabled>
                                                    <option value="" selected disabled>Select Role</option>
                                                    @foreach ($roles as $key => $role)
                                                        <option value="{{$role->id}}" @selected( $user->roles->pluck('name')[0] == $role->name)>{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="dob">Date of Birth</label>
                                                <input type="text" name="date_of_birth" class="form-control" id="datepicker" value="{{ old('date_of_birth', $user->date_of_birth) }}" placeholder="YYYY-MM-DD">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="branch">Branch</label>
                                                <select name="branch" id="branch" class="form-control">
                                                    <option value="" selected disabled>Select Branch</option>
                                                    @foreach ($branches as $key => $branch)
                                                        <option value="{{$branch->id}}" @selected($user->branch_id == $branch->id)>{{ $branch->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="role">Role <span style="color: red;">*</span></label>
                                                <select name="role" id="role" class="form-control" disabled>
                                                    <option value="" selected disabled>Select Role</option>
                                                    @foreach ($roles as $key => $role)
                                                        <option value="{{$role->id}}" @selected( $user->roles->pluck('name')[0] == $role->name)>{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="parent_category_id">Category</label>
                                                <select id="parent_category_id" name="parent_category_id[]" class="form-control chosen-select" multiple="multiple">
                                                    @php
                                                        $selected_categories = [];
                                                    @endphp    
                                                    @foreach($user->user_parent_categories as $parent_category)
                                                        @php
                                                            array_push($selected_categories, $parent_category->parent_category_name);
                                                        @endphp
                                                    @endforeach
                                                    <option value="select_all">Select All</option>
                                                        <option value="product" {{ in_array('product', $selected_categories) ? 'selected' : '' }}>Product</option>
                                                        <option value="service" {{ in_array('service', $selected_categories) ? 'selected' : '' }}>Service</option>
                                                        <option value="accessories" {{ in_array('accessories', $selected_categories) ? 'selected' : '' }}>Accessories</option>
                                                </select>
                                                <span class="form-control-danger" id="parent_category_id_error" style="display:none; color: #dc3545; font-size:12px;">Please select atleast 1 category.</span>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="branch">Additional Detail</label>
                                                <textarea id="additional_detail" name="additional_detail" class="form-control" rows="2" cols="50">{{ $user->additional_details }}</textarea>
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

            $(".chosen-select").chosen({
                width: '100%',
                no_results_text: "Oops, nothing found!"
            })
        })
    </script>
@endsection

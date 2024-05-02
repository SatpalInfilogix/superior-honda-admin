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
                                    <form action="{{ route('profile.update', Auth::id()) }}" method="post">
                                        @method('patch')
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <label for="first-name">First Name</label>
                                                <input type="text" name="first-name" class="form-control">
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label for="last-name">Last Name</label>
                                                <input type="text" name="last-name" class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="email-address">Email Address</label>
                                                <input type="email" name="email-address" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="employee-id">Emp ID</label>
                                                <input type="text" name="employee-id" class="form-control">
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="profile-picture">Profile Picture</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="profile-picture">
                                                    <label class="custom-file-label" for="profile-picture">Choose Image</label>
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
                                                <select name="role" id="role" class="form-control">
                                                    <option value="Super Admin">Super Admin</option>
                                                    <option value="Admin">Admin</option>
                                                    <option value="Customer Service">Customer Service</option>
                                                    <option value="Accountant">Accountant</option>
                                                    <option value="Inspection Manager">Inspection Manager</option>
                                                    <option value="Technician">Technician</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="dob">Date of Birth</label>
                                                <input type="text" name="dob" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="password">Password</label>
                                                <input type="text" name="password" class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="confirm-password">Confirm Password</label>
                                                <input type="text" name="confirm-password" class="form-control">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <button class="btn btn-primary">Update Profile</button>
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

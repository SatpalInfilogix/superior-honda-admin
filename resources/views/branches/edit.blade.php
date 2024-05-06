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
                                    <h5>Edit Branch</h5>
                                    <div class="float-right">
                                        <a href="{{ route('branches.index') }}" class="btn btn-primary btn-md">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('branches.update', $branch->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="name" label="Name" value="{{ old('name', $branch->name) }}"></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="timing">Timing</label>
                                                <input type="time" name="timing" class="form-control" value="{{ old('timing', $branch->timing) }}" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="operating_hours" label="Operating Hours" value="{{ old('operating_hours', $branch->operating_hours) }}"></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="branch_head" label="Branch Head" value="{{ old('branch_head', $branch->branch_head) }}"></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="address" label="Address" value="{{ old('address', $branch->address) }}"></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="pincode" label="Pincode" value="{{ old('pincode', $branch->pincode) }}"></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="status">Status</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="Working" @selected($branch->status == 'Working')>Working</option>
                                                    <option value="Not Working" @selected($branch->status == 'Not Working')>Not Working</option>
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
                    name: "required",
                    address: "required",
                    pincode: "required"
                },
                messages: {
                    name: "Please enter branch name",
                    address: "Please enter address",
                    pincode: "Please enter pincode"
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

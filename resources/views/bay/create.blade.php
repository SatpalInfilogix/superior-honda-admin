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
                                    <h5>Add Bay</h5>
                                    <div class="float-right">
                                        <a href="{{ route('bay.index') }}" class="btn btn-primary btn-md primary-btn">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('bay.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="name" label="Name" value="{{ old('name') }}"></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="branch_head">Branch</label>
                                                <select name="branch_head" id="branch_head" class="form-control">
                                                    <option value="" selected disabled>Select Branch</option>
                                                    @foreach ($branchesData as $key => $user)
                                                        <option value="{{$user->id}}">{{ $user->name }} - {{$user->address}}</option>
                                                    @endforeach
                                                </select>
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
            $('form').validate({
                rules: {
                    name: "required",
                    branch_head: "required",
                },
                messages: {
                    name: "Please enter bay name",
                    branch_head: "Please select branch",
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

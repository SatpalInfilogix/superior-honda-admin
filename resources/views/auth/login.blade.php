@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('authenticate') }}" class="md-float-material form-material">
        @csrf
        <div class="text-center">
            <img src="{{ asset('assets/images/logo.png') }}">
        </div>

        <div class="auth-box">
            @if ($errors->any())
                <div class="alert alert-danger background-danger alert-dismissible">
                    {{ $errors->first() }}
                    <button type="button" class="close mt-1" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card">
                <div class="card-block">
                    <div class="row m-b-20">
                        <div class="col-md-12">
                            <h3 class="text-center txt-primary">Sign In</h3>
                        </div>
                    </div>
                    <div class="form-group form-primary">
                        <input type="email" name="email" class="form-control" required="">
                        <span class="form-bar"></span>
                        <label class="float-label">Email Address</label>
                    </div>
                    <div class="form-group form-primary">
                        <input type="password" name="password" class="form-control" required="">
                        <span class="form-bar"></span>
                        <label class="float-label">Password</label>
                    </div>
                    <div class="row m-t-25 text-left">
                        <div class="col-12">
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" value="">
                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                    <span class="text-inverse">Remember me</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row m-t-30">
                        <div class="col-md-12">
                            <button type="submit"
                                class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">LOGIN</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection


@section('script')
    <script>
        $(function() {
            $("form").validate({
                errorClass: "text-danger f-12",
                errorElement: "span",
                errorPlacement: function(error, element) {
                    error.insertAfter(element.siblings("label"));
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).parent().removeClass("form-primary").addClass("form-danger");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).parent().removeClass("form-danger").addClass("form-primary");
                },
                submitHandler: function(form) {
                    console.log('..', $(element))
                    form.submit();
                }
            });
        })
    </script>
@endsection

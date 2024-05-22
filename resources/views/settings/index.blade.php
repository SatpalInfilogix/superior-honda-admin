@extends('layouts.app')

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            @if (session('success'))
                                <x-alert message="{{ session('success') }}"></x-alert>
                            @endif

                            <div class="card">
                                <div class="card-header">
                                    <h5>Settings</h5>
                                </div>

                                <div class="card-block">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <ul class="nav nav-tabs md-tabs tabs-left b-none w-100" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-toggle="tab" href="#general_setting"
                                                            role="tab">General Settings</a>
                                                        <div class="slide"></div>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#holidays"
                                                            role="tab">Business Hours/Holidays
                                                        </a>
                                                        <div class="slide"></div>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#paypal_setting"
                                                            role="tab">Paypal Settings</a>
                                                        <div class="slide"></div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-9">
                                                <div class="tab-content tabs-left-content card-block w-25">
                                                    @include('settings.partials.general-setting')
                                                    @include('settings.partials.business-hours-holiday')
                                                    @include('settings.partials.paypal-setting')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-include-plugins fullCalendar></x-include-plugins>
    @endsection

    @section('head')
        <link rel="stylesheet" href="{{ asset('assets/css/notification.css') }}">
    @endsection

    @section('script')
        <script src="{{ asset('assets/js/bootstrap-growl.min.js') }}"></script>

        <script>
            $('#add-banner').change(function() {
                var input = this;
                if (input.files && input.files[0]) {
                    $('#previewImg').prop('hidden', false);
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewImg').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });

            $('#add-logo').change(function() {
                var input = this;
                if (input.files && input.files[0]) {
                    $('#preview-Img').prop('hidden', false);
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview-Img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });

            $(function() {
                var icons = {
                    header: "fas fa-up-arrow",
                    activeHeader: "fas fa-down-arrow"
                };

                $(".settings").accordion({
                    heightStyle: "content",
                    icons: icons
                });

                $('form').validate({
                    rules: {
                        coupon_code: "required",
                        discount_type: "required",
                        discount_amount: "required"
                    },
                    messages: {
                        coupon_code: "Please enter coupon code",
                        discount_type: "Please enter discount type",
                        discount_amount: "Please choose discount amount"
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
        </script>
    @endsection

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
                                                    <div class="tab-pane active" id="general_setting" role="tabpanel">
                                                        <form action="{{ route('settings.general-setting') }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="form-group">
                                                                <x-input-text name="buisness_name" label="Business Name"
                                                                    value="{{ old('buisness_name', App\Helpers\SettingHelper::setting('buisness_name')) }}"></x-input-text>
                                                            </div>
                                                            <div class="form-group">
                                                                <x-input-text name="email" label="Email"
                                                                    value="{{ old('email', App\Helpers\SettingHelper::setting('email')) }}"></x-input-text>
                                                            </div>
                                                            <div class="form-group">
                                                                <x-input-text name="contact" label="Contact"
                                                                    value="{{ old('contact', App\Helpers\SettingHelper::setting('contact')) }}"></x-input-text>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="add-banner">Banner</label>
                                                                <div class="custom-file">
                                                                    <input type="file" name="banner"
                                                                        class="custom-file-input" id="add-banner">
                                                                    <label class="custom-file-label" for="add-banner">Choose
                                                                        Banner</label>
                                                                    @if(App\Helpers\SettingHelper::setting('banner') != '')
                                                                        <img src="{{ asset(App\Helpers\SettingHelper::setting('banner')) }}"  id="previewImg" class="img-preview" width="50" height="50">
                                                                    @else 
                                                                        <img src="" id="previewImg" height="50" width="50" name="image" hidden>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="add-logo">Logo</label>
                                                                <div class="custom-file">
                                                                    <input type="file" name="logo"
                                                                        class="custom-file-input" id="add-logo">
                                                                    <label class="custom-file-label" for="add-logo">Choose Logo</label>
                                                                    @if(App\Helpers\SettingHelper::setting('logo') != '')
                                                                    <img src="{{ asset(App\Helpers\SettingHelper::setting('logo')) }}"  id="preview-Img" class="img-preview" width="50" height="50">
                                                                    @else 
                                                                        <img src="" id="preview-Img" height="50" width="50" name="image" hidden>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </form>
                                                    </div>

                                                    <div class="tab-pane" id="holidays" role="tabpanel">
                                                        <h5 class="font-weight-bold">Business hours</h5>
                                                        <form action="{{ route('settings.general-setting') }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-lg-4">
                                                                    <label class="font-weight-bold">Weekday</label>
                                                                </div>

                                                                <div class="col-lg-4">
                                                                    <label class="font-weight-bold">Open Time</label>
                                                                </div>

                                                                <div class="col-lg-4">
                                                                    <label class="font-weight-bold">Close Time</label>
                                                                </div>
                                                            </div>
                                                            @php
                                                            if(App\Helpers\SettingHelper::timing('timings')) {
                                                                $weekdays = App\Helpers\SettingHelper::timing('timings');
                                                            } else {
                                                                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                                                $weekdays = array_flip($days);
                                                            }
                                                            @endphp
                                                            @foreach ( $weekdays as $key => $weekday)
                                                                <div class="row">
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label>{{ $key }}<label>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <input type="time" name="timings[{{ $key }}][start_time]" class="form-control" value="{{ $weekday->start_time ?? ' '}}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <input type="time" name="timings[{{ $key }}][end_time]" class="form-control" value="{{  $weekday->end_time ?? '' }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </form>
                                                    </div>

                                                    <div class="tab-pane" id="paypal_setting" role="tabpanel">
                                                        <form action="{{ route('settings.general-setting') }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="form-group">
                                                                <x-input-text name="api_key" label="API Key"
                                                                    value="{{ old('api_key', App\Helpers\SettingHelper::setting('api_key')) }}"></x-input-text>
                                                            </div>
                                                            <div class="form-group">
                                                                <x-input-text name="secret_key" label="Secret Key"
                                                                    value="{{ old('secret_key', App\Helpers\SettingHelper::setting('secret_key')) }}"></x-input-text>
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
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('head')
        <link rel="stylesheet" href="{{ asset('assets/css/notification.css') }}">
    @endsection

    @section('script')
        <script src="{{ asset('assets/js/bootstrap-growl.min.js') }}"></script>

        <script>
            $('#add-banner').change(function(){
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

            $('#add-logo').change(function(){
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
            })
        </script>
    @endsection

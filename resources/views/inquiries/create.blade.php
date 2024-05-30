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
                                    <h5>Inquiry Form</h5>
                                    <div class="float-right">
                                        <a href="{{ route('inquiries.index') }}" class="btn btn-primary btn-md primary-btn">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form method="post" action="{{ route('inquiries.store') }}" enctype="multipart/form-data">
                                        @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="name">Name:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="name" name="name"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="date">Date:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="date" class="form-control m-0"
                                                        id="datepicker">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="mileage">Mileage:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="mileage" name="mileage"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="vehicle">Vehicle:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="vehicle" name="vehicle"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="year">Year:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="year" name="year"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="licence_no">Licence No:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="licence_no" name="licence_no"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" for="address">Address:</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control m-0" id="address" name="address"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label" for="returning">Returning:</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control m-0" id="returning" name="returning"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label" for="color">Color:</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control m-0" id="color" name="color"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label" for="tel_digicel">TEL
                                                    Digicel:</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control m-0" id="tel_digicel" name="tel_digicel"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" for="email">Email:</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control m-0" id="email" name="email"
                                                        type="email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="tel_lime">TEL Lime:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="tel_lime" name="tel_lime"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="dob">Date of
                                                    Birth:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control m-0" id="datepicker2"
                                                        name="dob">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="chassis">Chassis:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="chassis" name="chassis"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <p>Kindly complete this checklist by placing a tick in the respective boxes.<br>
                                                Any discrepancies should be detailed in the section provided at the bottom
                                                of the sheet.</p>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="engine">Engine:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="engine" name="engine"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <p>ITEMS TO BE CHECKED:</p>
                                            <p>Start Engine check dashboard for the following indicators</p>
                                            <ul>
                                                <li>Fuel level</li>
                                                <li>Oil level</li>
                                                <li>Coolant level</li>
                                                <li>Power steering oil level</li>
                                                <li>Check tires for wear and pressure (20% 30% 50% 60% 80% 100% other
                                                    indicate)</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Engine Light</th>
                                                        <th>ABS Light</th>
                                                        <th>Brake Light</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>E 1/4</td>
                                                        <td>1/2 3/4</td>
                                                        <td>F</td>
                                                    </tr>
                                                    <tr>
                                                        <td>E 1/4</td>
                                                        <td>1/2 3/4</td>
                                                        <td>F</td>
                                                    </tr>
                                                    <tr>
                                                        <td>E 1/4</td>
                                                        <td>1/2 3/4</td>
                                                        <td>F</td>
                                                    </tr>
                                                    <tr>
                                                        <td>E 1/4</td>
                                                        <td>1/2 3/4</td>
                                                        <td>F</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                        </div>
                                        <div class="col-md-5">
                                            <span class="col-sm-8"> </span><span class="col-sm-2">Good</span><span
                                                class="col-sm-2">Defective</span>
                                        </div>
                                        <div class="col-md-5">
                                            <span class="col-sm-8"></span><span class="col-sm-2">Good</span><span
                                                class="col-sm-2">Defective</span>
                                        </div>
                                    </div><br>

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            @php
                                                $products1 = [
                                                    'Horn',
                                                    'Carpet',
                                                    'Battery',
                                                    'Battery Clamps',
                                                    'Left Headlight',
                                                    'Right Headlight',
                                                    'Left Indicator',
                                                    'Right Front Fender',
                                                    'Left Front Fender',
                                                    'Right Front Door',
                                                    'Left Front Door',
                                                    'Left Rear Door',
                                                    'Right Rear Door',
                                                    'Left Tail Lamp',
                                                    'Right Tail Lamp',
                                                    'Hub Caps',
                                                    'Cigarette Lighter',
                                                    'Grill',
                                                ];
                                            @endphp
                                            @foreach ($products1 as $key => $product)
                                                <label class="col-sm-6">{{ $product }}</label>
                                                <div class="form-check form-check-inline col-sm-2">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input status-checkbox"
                                                            id="{{ strtolower(str_replace(' ', '_', $product)) }}_status[]"
                                                            type="checkbox"
                                                            name="products[{{ strtolower(str_replace(' ', '_', $product)) }}][condition]"
                                                            value="good">
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline col-sm-2">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input status-checkbox"
                                                            id="{{ strtolower(str_replace(' ', '_', $product)) }}_status[]"
                                                            type="checkbox"
                                                            name="products[{{ strtolower(str_replace(' ', '_', $product)) }}][condition]"
                                                            value="defective">
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-md-6 form-group">
                                            @php
                                                $products2 = [
                                                    'Reverse Light',
                                                    'Rear Door or Trunk',
                                                    'Window Functions',
                                                    'Oil Cap',
                                                    'Left Quarter Panel',
                                                    'Right Quarter Panel',
                                                    'Front Bumper',
                                                    'Rear Bumper',
                                                    'Left Wing Mirror',
                                                    'Right Wing Mirror',
                                                    'Rims',
                                                    'Interior Lights',
                                                    'Seats',
                                                    'Door Pulls',
                                                    'Rear Windshield',
                                                    'Front Windshield',
                                                    'Spare Tire',
                                                    'Jack & Handle',
                                                    'Wipers & Washer Jets',
                                                ];
                                            @endphp

                                            @foreach ($products2 as $key => $product)
                                                <label class="col-sm-6">{{ $product }}</label>
                                                <div class="form-check form-check-inline col-sm-2">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input status-checkbox" type="checkbox"
                                                            id="{{ strtolower(str_replace(' ', '_', $product)) }}_status[]"
                                                            name="products[{{ strtolower(str_replace(' ', '_', $product)) }}][condition]"
                                                            value="good">
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline col-sm-2">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input status-checkbox" type="checkbox"
                                                            id="{{ strtolower(str_replace(' ', '_', $product)) }}_status[]"
                                                            name="products[{{ strtolower(str_replace(' ', '_', $product)) }}][condition]"
                                                            value="defective">
                                                    </label>
                                                </div><br>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>Following discrepancies were noted:
                                                .......................................................</p>
                                            <p>I hereby authorize Superior Parts Limited to effect repairs and supply
                                                necessary materials
                                                relating to this job and grant your employees permission to operate the
                                                vehicle described above
                                                on streets, highways, and elsewhere for testing and inspection.</p>
                                            <p>50% deposit is to be made on all jobs.</p>
                                            <p>Superior Parts Ltd will not be held responsible for jobs left over 30 days.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="date">Date:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control m-0" name="sign_date" id="date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 form-group row">
                                            <label class="col-sm-4 col-form-label">Customer's Signature:</label>
                                            <div class="col-sm-8">
                                                <canvas id="sig-canvas" width="400" height="130">
                                                    Get a better browser, bro.
                                                </canvas>
                                                <input id="sig-dataUrl" class="form-control" type="hidden" name="signature">
                                                <button type="button" class="btn btn-default" id="sig-clearBtn">Clear Signature</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br />
                                    <button id="sig-submitBtn" class="btn btn-primary primary-btn">Save</button>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-signature-pad signature></x-signature-pad>
    <script>
        $(function() {
            $('.status-checkbox').change(function() {
                var type = $(this).attr('id');
                $('.status-checkbox[id="' + type + '"]').not(this).prop('checked', false);
            });

            $('form').validate({
                rules: {
                    name: "required",
                    mileage: "required",
                    licence_no: "required",
                    tel_digicel: "required",
                    tel_lime: "required",
                    dob: "required",
                },
                messages: {
                    name: "Please enter name",
                    mileage: "Please enter mileage",
                    licence_no: "Please enter licence no",
                    tel_digicel: "Please enter tel digicel",
                    tel_lime:"Please enter tel lime",
                    dob: "Please enter date of birth",
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

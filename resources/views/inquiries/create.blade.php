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
                                        <a href="{{ route('customers.index') }}" class="btn btn-primary btn-md">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('customers.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="name" label="Name"
                                                    value="{{ old('name') }}"></x-input-text>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <x-input-text name="date" label="Date"
                                                    value="{{ old('date') }}"></x-input-text>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <x-input-text name="mileage" label="Mileage"
                                                    value="{{ old('mileage') }}"></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="vehicle" label="Vehicle"
                                                    value="{{ old('vehicle') }}"></x-input-text>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <x-input-text name="year" label="Year"
                                                    value="{{ old('year') }}"></x-input-text>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <x-input-text name="lic_no" label="Lic No"
                                                    value="{{ old('lic_no') }}"></x-input-text>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <x-input-text name="address" label="Address"
                                                value="{{ old('address') }}"></x-input-text>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="address" label="Returning"
                                                    value="{{ old('address') }}"></x-input-text>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <x-input-text name="color" label="Color"
                                                    value="{{ old('color') }}"></x-input-text>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <x-input-text name="tel_digicel" label="TEL Digicel"
                                                    value="{{ old('tel_digicel') }}"></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="email" label="Email"
                                                    value="{{ old('email') }}"></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="tel_lime" label="TEL Lime"
                                                    value="{{ old('tel_lime') }}"></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="dob" label="Date of Birth"
                                                    value="{{ old('dob') }}"></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="chassis" label="Chassis"
                                                    value="{{ old('Chassis') }}"></x-input-text>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8 form-group">
                                                <p>Kindly complete this checklist by placing a tick in the
                                                    respective boxes.<br>
                                                    Any discrepancies should be detailed in the section provided at the bottom of the sheet.
                                                </p>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <x-input-text name="engine" label="Engine"
                                                    value="{{ old('engine') }}"></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8 form-group">
                                                <p>ITEMS TO BE CHECKED:</p>
                                                <p>Start Engine check dashboardfor the following indecators</p>
                                                <p>Fuel level</p>
                                                <p>Oil level</p>
                                                <p>Coolant level</p>
                                                <p>Power steering oil level</p>
                                                <p>Check tires for wear and pressure</p>
                                                <p>(20% 30% 50% 60% 80% 100% other indicate)</p>

                                            </div>
                                            <div class="col-md-4 form-group">
                                                <table  class="table  table-bordered ">
                                                    <thead>
                                                        <tr>
                                                            <th>Engine Light</th>
                                                            <th>ABS Light</th>
                                                            <th>Brake Light</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th>E 1/4</th>
                                                            <th>1/2  3/4</th>
                                                            <th>F</th>
                                                        </tr>
                                                        <tr>
                                                            <th>E 1/4</th>
                                                            <th>1/2  3/4</th>
                                                            <th>F</th>
                                                        </tr>
                                                        <tr>
                                                            <th>E 1/4</th>
                                                            <th>1/2  3/4</th>
                                                            <th>F</th>
                                                        </tr>
                                                        <tr>
                                                            <th>E 1/4</th>
                                                            <th>1/2  3/4</th>
                                                            <th>F</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="col-sm-5"></label>
                                                <label class="col-sm-2"> Good</label>
                                                <label class="col-sm-1.5"> Defactive</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-sm-5"></label>
                                                <label class="col-sm-2"> Good</label>
                                                <label class="col-sm-1.5"> Defactive</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                @php $types = ['Horn', 'Carpet', 'Battery', 'Battery Clamps', 'Left Headlight', 'Right Headlight', 'Left Indicator', 'Right Front Fender', 'Left Front Fender', 'Right Front Door', 'Left Front Door', 'Left Rear Door', 'right Rear Door', 'Left Tail Lamp', 'Right Tail Lamp', 'Hub Caps', 'Cigarette Lighter', 'Grill']; @endphp
                                                @foreach ($types as $type)
                                                <label class="col-sm-6">{{$type}}</label>
                                                <div class="form-check form-check-inline col-sm-1">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="good" id="gender-1" value="option1">
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline col-sm-1">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="defective" id="gender-2" value="option2">
                                                    </label>
                                                </div></br>
                                                @endforeach
                                            </div>
                                            <div class="col-md-6 form-group">
                                                @php $types = ['Reverse Light', 'Rear Door or Trunk', 'Window Functions', 'Oil Cap', 'Left Quarter Panel', 'Right Quarter Panel', 'Front Bumper', 'Rear Bumper', 'Left Wing Mirror', 'Right Wing Mirror', 'Rims', 'Interior Lights', 'Seats', 'Door Pulls', 'Rear Windshield', 'Front Windshield', 'Spare Tire', 'Jack & Handle', 'Wipers & Washer Jets']; @endphp
                                                @foreach ($types as $type)
                                                <label class="col-sm-6">{{$type}}</label>
                                                <div class="form-check form-check-inline col-sm-2">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="good" id="gender-1" value="option1">
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline col-sm-2">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="defective" id="gender-2" value="option2">
                                                    </label>
                                                </div></br>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="<row>">
                                            <p>Following Discrepancies where noted:.......................................................</p>
                                            <p> I HERE BY AUTHORIZE SUPERIOR PARTS LIMITED TO EFFECT REPAIRS AND SUPPLY  NECESSARY  MATERIALS RELATING TO THIS JOB AND GRANT YOUR EMPLOYEES PERMISSION  TO OPERATE THE VEHICLE DESCRIBED ABOVE ON STREETS, HIGHWAYS AND ELSEWHERE FOR TESTING AND INSPECTION.</p>
                                            <P> 50% DEPOSIT IS TO BE MADE ON ALL JOBS</P>
                                            <P> SUPERIOR PARTS LTD WILL NOT BE HELD RESPONSIBLE FOR JOBS LEFT OVER 30 DAYS. </P>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-5 form-group">
                                                <label>Date</label>
                                                <input type="date" name="date" label="Date"
                                                    value="{{ old('date') }}" class="form-control"/>
                                            </div>
                                            <div class="col-md-7 form-group">
                                                <label>Customer's Signature</label>
                                                <canvas id="sig-canvas" width="550" height="130">
                                                    Get a better browser, bro.
                                                </canvas>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input id="sig-dataUrl" class="form-control" type="hidden">
                                            </div>
                                        </div>
                                        {{-- <button type="submit" class="btn btn-primary">Save</button> --}}
                                    </form>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" id="sig-submitBtn">Submit Signature</button>
                                            <button class="btn btn-default" id="sig-clearBtn">Clear Signature</button>
                                        </div>
                                    </div>
                                    <br/>
                                    <!--div class="row">
                                        <div class="col-md-12">
                                            <img style="display:none;" id="sig-image" src="" alt="Your signature will go here!"/>
                                        </div>
                                    </div-->
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
                    first_name: "required",
                    last_name: "required",
                    email: "required",
                    phone_digicel: "required"

                },
                messages: {
                    first_name: "Please enter first name",
                    last_name: "Please enter last name",
                    email: "Please enter email",
                    phone_digicel: "Please enter phone digicel",

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

        // Canvas signature script
        $(function() {
            window.requestAnimFrame = (function(callback) {
                return window.requestAnimationFrame ||
                    window.webkitRequestAnimationFrame ||
                    window.mozRequestAnimationFrame ||
                    window.oRequestAnimationFrame ||
                    window.msRequestAnimaitonFrame ||
                    function(callback) {
                        window.setTimeout(callback, 1000 / 60);
                    };
            })();

            var canvas = $("#sig-canvas")[0];
            var ctx = canvas.getContext("2d");
            ctx.strokeStyle = "#222222";
            ctx.lineWidth = 4;

            var drawing = false;
            var mousePos = {
                x: 0,
                y: 0
            };
            var lastPos = mousePos;

            $(canvas).on("mousedown", function(e) {
                drawing = true;
                lastPos = getMousePos(canvas, e);
            });

            $(canvas).on("mouseup", function(e) {
                drawing = false;
            });

            $(canvas).on("mousemove", function(e) {
                mousePos = getMousePos(canvas, e);
            });

            // Add touch event support for mobile
            $(canvas).on("touchstart", function(e) {
                e.preventDefault();
                mousePos = getTouchPos(canvas, e);
                var touch = e.touches[0];
                var me = new MouseEvent("mousedown", {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(me);
            });

            $(canvas).on("touchmove", function(e) {
                var touch = e.touches[0];
                var me = new MouseEvent("mousemove", {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(me);
            });

            $(canvas).on("touchend", function(e) {
                var me = new MouseEvent("mouseup", {});
                canvas.dispatchEvent(me);
            });

            function getMousePos(canvasDom, mouseEvent) {
                var rect = canvasDom.getBoundingClientRect();
                return {
                    x: mouseEvent.clientX - rect.left,
                    y: mouseEvent.clientY - rect.top
                };
            }

            function getTouchPos(canvasDom, touchEvent) {
                var rect = canvasDom.getBoundingClientRect();
                return {
                    x: touchEvent.touches[0].clientX - rect.left,
                    y: touchEvent.touches[0].clientY - rect.top
                };
            }

            function renderCanvas() {
                if (drawing) {
                    ctx.moveTo(lastPos.x, lastPos.y);
                    ctx.lineTo(mousePos.x, mousePos.y);
                    ctx.stroke();
                    lastPos = mousePos;
                }
            }

            // Prevent scrolling when touching the canvas
            $(document.body).on("touchstart touchend touchmove", function(e) {
                if ($(e.target).is(canvas)) {
                    e.preventDefault();
                }
            });

            (function drawLoop() {
                requestAnimFrame(drawLoop);
                renderCanvas();
            })();

            function clearCanvas() {
                canvas.width = canvas.width;
            }

            // Set up the UI
            var sigText = $("#sig-dataUrl")[0];
            var sigImage = $("#sig-image")[0];
            var clearBtn = $("#sig-clearBtn")[0];
            var submitBtn = $("#sig-submitBtn")[0];

            $(clearBtn).on("click", function(e) {
                clearCanvas();
                sigText.value = "Data URL for your signature will go here!";
                sigImage.setAttribute("src", "");
                $(sigImage).css("display", "none");
            });

            $(submitBtn).on("click", function(e) {
                var dataUrl = canvas.toDataURL();
                sigText.value = dataUrl;
                sigImage.setAttribute("src", dataUrl);
                $(sigImage).css("display", "block");
            });
        });

    </script>
@endsection

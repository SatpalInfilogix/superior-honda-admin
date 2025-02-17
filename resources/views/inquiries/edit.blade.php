@extends('layouts.app')

@section('content')
<style>
    .modal-content {
        width: 130%;
    }
    .primary-btn {
        margin-left: 10px;
        color:white;
    }
    .input-group-append {
        margin-left: 23px !important;
    }
</style>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Edit Inquiry Form</h5>
                                    <div class="float-right">
                                        <button class="btn btn-primary btn-md primary-btn" id="openPopupBtn" type="button" data-toggle="modal" data-target="#myModal">Previous Licence History</button>
                                        <a href="{{ route('inquiries.index') }}" class="btn btn-primary btn-md primary-btn">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form method="post" action="{{ route('inquiries.update', $inquiry->id) }}">
                                        @csrf
                                        @method('PATCH')
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="name">Name:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="name" name="name" value="{{ $inquiry->name }}"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="date">Date:</label>
                                                <div class="col-sm-9">
                                                    <input type="date" name="date" class="form-control m-0" value="{{ $inquiry->date }}"
                                                        id="datepicker">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="mileage">Mileage:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="mileage" name="mileage" value="{{ $inquiry->mileage }}"
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
                                                    <input class="form-control m-0" id="vehicle" name="vehicle" value="{{ $inquiry->vehicle }}"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="year">Year:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="year" name="year" value="{{ $inquiry->year }}"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="licence_no">Licence No:</label>
                                                <div class="col-sm-9">
                                                    <div class="input-grou">
                                                        <input type="text" class="form-control" id="licence_no" name="licence_no" value="{{ $inquiry->licence_no }}">
                                                    </div>
                                                    <span class="text-success mt-2" style="font-size: 12px;">Enter licence number to preview licence history.</span>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="licence_no">Lic No:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="licence_no" name="licence_no" value="{{ $inquiry->licence_no }}"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" for="address">Address:</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control m-0" id="address" name="address" value="{{ $inquiry->address }}"
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
                                                    <input class="form-control m-0" id="returning" name="returning" value="{{ $inquiry->returning }}"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label" for="color">Color:</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control m-0" id="color" name="color" value="{{ $inquiry->color }}"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label" for="tel_digicel">TEL
                                                    Digicel:</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control m-0" id="tel_digicel" name="tel_digicel" value="{{ $inquiry->tel_digicel }}"
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
                                                    <input class="form-control m-0" id="email" name="email" value="{{ $inquiry->email }}"
                                                        type="email" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="tel_lime">TEL Lime:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="tel_lime" name="tel_lime" value="{{ $inquiry->tel_lime }}"
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
                                                    <input type="date" class="form-control m-0" id="datepicker2" value="{{ $inquiry->dob }}"
                                                        name="dob">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="chassis">Chassis:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="chassis" name="chassis" value="{{ $inquiry->chassis }}"
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
                                                    <input class="form-control m-0" id="engine" name="engine" value="{{ $inquiry->engine }}"
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
                                            <div class="form-group">
                                                <label class="col-form-label" for="notes">Notes:</label>
                                                <div class="">
                                                    <textarea class="form-control m-0" id="notes" name="notes" rows="2" cols="200">{{$inquiry->notes}}</textarea>
                                                </div>
                                            </div>
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
                                    <?php  $data = json_decode($inquiry->conditions); ?>
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
                                                            value="good" @if($data) {{ in_array(strtolower(str_replace(' ', '_', $product)), array_column($data, 'product')) && $data[array_search(strtolower(str_replace(' ', '_', $product)), array_column($data, 'product'))]->condition == 'good' ? 'checked' : '' }} @endif>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline col-sm-2">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input status-checkbox"
                                                            id="{{ strtolower(str_replace(' ', '_', $product)) }}_status[]"
                                                            type="checkbox"
                                                            name="products[{{ strtolower(str_replace(' ', '_', $product)) }}][condition]"
                                                            value="defective" @if($data){{ in_array(strtolower(str_replace(' ', '_', $product)), array_column($data, 'product')) && $data[array_search(strtolower(str_replace(' ', '_', $product)), array_column($data, 'product'))]->condition == 'defective' ? 'checked' : '' }} @endif>
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
                                                            value="good" @if($data) {{ in_array(strtolower(str_replace(' ', '_', $product)), array_column($data, 'product')) && $data[array_search(strtolower(str_replace(' ', '_', $product)), array_column($data, 'product'))]->condition == 'good' ? 'checked' : '' }} @endif>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline col-sm-2">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input status-checkbox" type="checkbox"
                                                            id="{{ strtolower(str_replace(' ', '_', $product)) }}_status[]"
                                                            name="products[{{ strtolower(str_replace(' ', '_', $product)) }}][condition]"
                                                            value="defective" @if($data) {{ in_array(strtolower(str_replace(' ', '_', $product)), array_column($data, 'product')) && $data[array_search(strtolower(str_replace(' ', '_', $product)), array_column($data, 'product'))]->condition == 'defective' ? 'checked' : '' }} @endif>
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
                                                    <input class="form-control m-0 " id="date" name="sign_date" type="date" value="{{ $inquiry->sign_date }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 form-group row">
                                            <label class="col-sm-4 col-form-label">Customer's Signature:</label>
                                            <div class="col-sm-8">
                                                <img src="{{ asset($inquiry->sign)}}" width="100" height="100">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">                                            
                                            <label class="col-sm-4 col-form-label">Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="pending" {{ $inquiry->status == 'pending' ? 'selected' : ''; }}>Pending</option>
                                                <option value="in progress" {{ $inquiry->status == 'in progress' ? 'selected' : ''; }}>In Progress</option>
                                                <option value="completed" {{ $inquiry->status == 'completed' ? 'selected' : ''; }}>Completed</option>
                                            </select>
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

     <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Inquery Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="inquery-table">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Licence no</th>
                                        <th>Action</th>
                                    </tr>
                                <tbody id="inquery"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- Add additional buttons or controls here if needed -->
                    </div>
                </div>
            </div>
        </div>
    <script>
        $(document).ready(function() {
            $('#openPopupBtn').click(function() {
                var licenseNo = $('#licence_no').val();
                var type = 'edit';
                $.ajax({
                    url: '/inquery-data',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        licenseNo: licenseNo,
                        type: type,
                    },
                    success: function(response) {
                        if (response.html == '') {
                            $('.inquery-table').addClass('d-none');
                        } else {
                            $('#inquery').html(response.html);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });

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
                    dob: "required",
                    tel_digicel: {
                        required: function(element) {
                            return $('#tel_lime').val() === '';
                        }
                    },
                    tel_lime: {
                        required: function(element) {
                            return $('#tel_digicel').val() === '';
                        }
                    }
                },
                messages: {
                    name: "Please enter name",
                    mileage: "Please enter mileage",
                    licence_no: "Please enter licence no",
                    dob: "Please enter date of birth",
                    tel_digicel: "Please enter at least one phone number (Digicel or Lime)",
                    tel_lime: "Please enter at least one phone number (Digicel or Lime)",
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

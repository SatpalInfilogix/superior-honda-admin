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
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="name">Name:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="name" name="name"
                                                        value="{{ $inquiry->name }}" type="text" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="date">Date:</label>
                                                <div class="col-sm-9">
                                                    <input type="date" name="date" class="form-control m-0"
                                                        value="{{ $inquiry->date }}" id="datepicker" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="mileage">Mileage:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="mileage" name="mileage"
                                                        value="{{ $inquiry->mileage }}" type="text" readonly>
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
                                                        value="{{ $inquiry->vehicle }}" type="text" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="year">Year:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="year" name="year"
                                                        value="{{ $inquiry->vehicle }}" type="text" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="lic_no">Lic No:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="lic_no" name="lic_no"
                                                        value="{{ $inquiry->lic_no }}" type="text" readonly>
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
                                                        value="{{ $inquiry->address }}" type="text" readonly>
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
                                                        value="{{ $inquiry->returning }}" type="text" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label" for="color">Color:</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control m-0" id="color" name="color"
                                                        value="{{ $inquiry->color }}" type="text" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label" for="tel_digicel">TEL
                                                    Digicel:</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control m-0" id="tel_digicel" name="tel_digicel"
                                                        value="{{ $inquiry->tel_digicel }}" type="text" readonly>
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
                                                        value="{{ $inquiry->email }}" type="email" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="tel_lime">TEL Lime:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="tel_lime" name="tel_lime"
                                                        value="{{ $inquiry->tel_lime }}" type="text" readonly>
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
                                                    <input type="date" class="form-control m-0" id="date"
                                                        value="{{ $inquiry->dob }}" name="dob" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="chassis">Chassis:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="chassis" name="chassis"
                                                        value="{{ $inquiry->chassis }}" type="text" readonly>
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
                                                        value="{{ $inquiry->engine }}" type="text" readonly>
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
                                    </div><br><br>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h6 class="font-weight-bold">Products</h6>
                                        </div>
                                        <div class="col-md-3">
                                            <h6 class="font-weight-bold">Conditions</h6>
                                        </div>
                                        <div class="col-md-3">
                                            <h6 class="font-weight-bold">Products</h6>
                                        </div>
                                        <div class="col-md-3">
                                            <h6 class="font-weight-bold">Conditions</h6>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @if($inquiry->conditions)
                                            @foreach (json_decode($inquiry->conditions) as $key => $product)
                                                <div class="col-md-3">
                                                    <label>{{ ucwords(str_replace('_', ' ', $product->product)) }}</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>{{ ucwords($product->condition) }}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div><br><br>

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
                                                    <input class="form-control m-0 " id="date" name="sign_date"
                                                        type="date" value="{{ $inquiry->sign_date }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 form-group row">
                                            <label class="col-sm-4 col-form-label">Customer's Signature:</label>
                                            <div class="col-sm-8">
                                                <img src="{{ asset($inquiry->sign) }}" width="100" height="100">
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

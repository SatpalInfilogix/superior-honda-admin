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
                                    <h5>Inspection Form</h5>
                                    <div class="float-right">
                                        <a href="{{ route('inspection.index') }}" class="btn btn-primary btn-md primary-btn">
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
                                                        value="{{ $inspection->name }}" type="text" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="date">Date:</label>
                                                <div class="col-sm-9">
                                                    <input type="date" name="date" class="form-control m-0"
                                                        value="{{ $inspection->date }}" id="datepicker" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="mileage">Mileage:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="mileage" name="mileage"
                                                        value="{{ $inspection->mileage }}" type="text" readonly>
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
                                                        value="{{ $inspection->vehicle }}" type="text" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="year">Year:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="year" name="year"
                                                        value="{{ $inspection->year }}" type="text" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="licence_no">Licence No:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="licence_no" name="licence_no"
                                                        value="{{ $inspection->licence_no }}" type="text" readonly>
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
                                                        value="{{ $inspection->address }}" type="text" readonly>
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
                                                        value="{{ $inspection->returning }}" type="text" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label" for="color">Color:</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control m-0" id="color" name="color"
                                                        value="{{ $inspection->color }}" type="text" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label" for="tel_digicel">TEL
                                                    Digicel:</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control m-0" id="tel_digicel" name="tel_digicel"
                                                        value="{{ $inspection->tel_digicel }}" type="text" readonly>
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
                                                        value="{{ $inspection->email }}" type="email" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="tel_lime">TEL Lime:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="tel_lime" name="tel_lime"
                                                        value="{{ $inspection->tel_lime }}" type="text" readonly>
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
                                                        value="{{ $inspection->dob }}" name="dob" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="chassis">Chassis:</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control m-0" id="chassis" name="chassis"
                                                        value="{{ $inspection->chassis }}" type="text" readonly>
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
                                                        value="{{ $inspection->engine }}" type="text" readonly>
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
                                                    <textarea class="form-control m-0" id="notes" name="notes" rows="2" cols="200" readonly>{{ $inspection->notes }}</textarea>
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
                                        @if($inspection->conditions)
                                            @foreach (json_decode($inspection->conditions) as $key => $product)
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
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label font-weight-bold">Services:</label>
                                                <div class="col-sm-8">
                                                    <ul>
                                                        @foreach($services as $service)
                                                            @if(in_array($service->id, (array) old('services', $inspection->services ?? [])))
                                                                <li>{{ $service->name }}</li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="name">Branch:</label>
                                                <div class="col-sm-9">
                                                    <select name="branch_id" id="branch_id" class="form-control m-0" disabled>
                                                        <option value="Select Branch">Select Branch</option>
                                                        @foreach($branches as $key => $branch)
                                                            <option value="{{$branch->id}}" @selected($branch->id == $inspection->branch_id)>{{ ucwords($branch->name) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="date">Bay:</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="bay_id" name="bay_id" disabled>
                                                        <option value="" selected disabled>Select Bay</option>
                                                        @if($bays)
                                                            @foreach($bays as $bay)
                                                                <option value="{{$bay->id}}" @selected($bay->id == $inspection->bay_id)>{{ $bay->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="mileage">User:</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="user_id" name="user_id" disabled>
                                                        <option value="" selected disabled>Select User</option>
                                                        @if($users)
                                                            @foreach($users as $user)
                                                                <option value="{{$user->id}}" @selected($user->id == $inspection->user_id)>{{ $user->first_name.' '.$user->last_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
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
                                                    <input class="form-control m-0 " id="date" name="sign_date"
                                                        type="date" value="{{ $inspection->sign_date }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 form-group row">
                                            <label class="col-sm-4 col-form-label">Customer's Signature:</label>
                                            <div class="col-sm-8">
                                                <img src="{{ asset($inspection->sign) }}" width="100" height="100">
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

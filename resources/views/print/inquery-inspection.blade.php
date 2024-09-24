<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inspection Form</title>
    <style>
        body {
            margin: 20px;
            font-family: Arial, sans-serif;
        }

        .container {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }

        .row {
            display: flex;
            margin-bottom: 10px;
        }

        .col-md-4, .col-md-3, .col-md-6, .col-md-5, .col-md-12 {
            padding: 5px;
        }

        .col-md-4, .col-md-3 {
            flex: 1;
        }

        .col-md-6, .col-md-5 {
            flex: 1.5;
        }

        .col-md-12 {
            flex: 2;
        }

        label {
            font-weight: bold;
        }

        input[type="text"], input[type="date"], input[type="email"], select, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        h3, h6 {
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .discrepancy-notes {
            border: 1px dashed #000;
            padding: 10px;
            margin-top: 20px;
        }

        .signature-img {
            border: 1px solid #000;
            padding: 5px;
            margin-top: 10px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="text-center">
            <h3 style="text-align: center; margin-bottom: 50px;">Inquery Form</h3>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="name">Name:</label>
                <input id="name" value="{{ $records->name }}" type="text" readonly>
            </div>
            <div class="col-md-4">
                <label for="date">Date:</label>
                <input type="date" id="date" value="{{ $records->date }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="mileage">Mileage:</label>
                <input id="mileage" value="{{ $records->mileage }}" type="text" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5">
                <label for="vehicle">Vehicle:</label>
                <input id="vehicle" value="{{ $records->vehicle }}" type="text" readonly>
            </div>
            <div class="col-md-3">
                <label for="year">Year:</label>
                <input id="year" value="{{ $records->year }}" type="text" readonly>
            </div>
            <div class="col-md-4">
                <label for="licence_no">Licence No:</label>
                <input id="licence_no" value="{{ $records->licence_no }}" type="text" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <label for="address">Address:</label>
                <input id="address" value="{{ $records->address }}" type="text" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label for="returning">Returning:</label>
                <input id="returning" value="{{ $records->returning }}" type="text" readonly>
            </div>
            <div class="col-md-3">
                <label for="color">Color:</label>
                <input id="color" value="{{ $records->color }}" type="text" readonly>
            </div>
            <div class="col-md-5">
                <label for="tel_digicel">TEL Digicel:</label>
                <input id="tel_digicel" value="{{ $records->tel_digicel }}" type="text" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="email">Email:</label>
                <input id="email" value="{{ $records->email }}" type="email" readonly>
            </div>
            <div class="col-md-6">
                <label for="tel_lime">TEL Lime:</label>
                <input id="tel_lime" value="{{ $records->tel_lime }}" type="text" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" value="{{ $records->dob }}" readonly>
            </div>
            <div class="col-md-6">
                <label for="chassis">Chassis:</label>
                <input id="chassis" value="{{ $records->chassis }}" type="text" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <p>Kindly complete this checklist by placing a tick in the respective boxes.<br>
                    Any discrepancies should be detailed in the section provided at the bottom of the sheet.</p>
            </div>
            <div class="col-md-4">
                <label for="engine">Engine:</label>
                <input id="engine" value="{{ $records->engine }}" type="text" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <p>ITEMS TO BE CHECKED:</p>
                <p>Start Engine check dashboard for the following indicators:</p>
                <ul>
                    <li>Fuel level</li>
                    <li>Oil level</li>
                    <li>Coolant level</li>
                    <li>Power steering oil level</li>
                    <li>Check tires for wear and pressure</li>
                </ul>
                <div class="form-group">
                    <label for="notes">Notes:</label>
                    <textarea id="notes" rows="2" readonly>{{ $records->notes }}</textarea>
                </div>
            </div>
            <div class="col-md-4">
                <table class="table">
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

        <div class="row products" style="margin-bottom: -11px;">
            <div class="col-md-3">
                <h4><strong>Products</strong></h4>
            </div>
            <div class="col-md-3">
                <h4><strong>Conditions</strong></h4>
            </div>
            <div class="col-md-3">
                <h4><strong>Products</strong></h4>
            </div>
            <div class="col-md-3">
                <h4><strong>Conditions</strong></h4>
            </div>
        </div>
        
        @php
            $conditions = json_decode($records->conditions);
        @endphp

        @if($conditions)
            @for ($i = 0; $i < count($conditions); $i += 2)
                <div class="row">
                    <div class="col-md-3">
                        <span>{{ ucwords(str_replace('_', ' ', $conditions[$i]->product)) }}</span>
                    </div>
                    <div class="col-md-3">
                        <span>{{ ucwords($conditions[$i]->condition) }}</span>
                    </div>
                    @if (isset($conditions[$i + 1]))
                        <div class="col-md-3">
                            <span>{{ ucwords(str_replace('_', ' ', $conditions[$i + 1]->product)) }}</span>
                        </div>
                        <div class="col-md-3">
                            <span>{{ ucwords($conditions[$i + 1]->condition) }}</span>
                        </div>
                    @else
                        <div class="col-md-3"></div> <!-- Empty column for alignment -->
                        <div class="col-md-3"></div> <!-- Empty column for alignment -->
                    @endif
                </div>
            @endfor
        @endif
        

        @if($records->services || $records->branch_id) 
            <div class="row">
                <div class="col-md-6">
                    <label>Services:</label>
                    <ul>
                        @foreach($services as $service)
                            @if(in_array($service->id, (array) old('services', $records->services ?? [])))
                                <li>{{ $service->name }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label for="branch_id">Branch:</label>
                    <select id="branch_id" disabled>
                        <option value="Select Branch">Select Branch</option>
                        @foreach($branches as $branch)
                            <option value="{{$branch->id}}" @selected($branch->id == $records->branch_id)>{{ ucwords($branch->name) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="bay_id">Bay:</label>
                    <select id="bay_id" disabled>
                        <option value="" selected disabled>Select Bay</option>
                        @foreach($bays as $bay)
                            <option value="{{$bay->id}}" @selected($bay->id == $records->bay_id)>{{ $bay->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="user_id">User:</label>
                    <select id="user_id" disabled>
                        <option value="" selected disabled>Select User</option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}" @selected($user->id == $records->user_id)>{{ $user->first_name.' '.$user->last_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <p>Following discrepancies were noted:...................................</p>
                <p>I hereby authorize Superior Parts Limited to effect repairs and supply necessary materials relating to this job.</p>
                <p>50% deposit is to be made on all jobs. Superior Parts Ltd will not be held responsible for jobs left over 30 days.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label for="sign_date">Date:</label>
                <input type="date" id="sign_date" value="{{ $records->sign_date }}">
            </div>
            <div class="col-md-8">
                <label>Customer's Signature:</label>
                <img src="{{ asset($records->sign) }}" width="100" height="100" class="signature-img">
            </div>
        </div>
    </div>

</body>

</html>

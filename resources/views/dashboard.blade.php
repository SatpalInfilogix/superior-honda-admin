@extends('layouts.app')

@section('content')
    <style>
        .container {
            font-family: Arial, sans-serif;
            width: 100%;
            max-width: 80%;
            margin: 20px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            float: left;
        }
        .scrollable-div {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
            box-sizing: border-box;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            .scrollable-div {
                padding: 8px;
            }
            th, td {
                padding: 8px;
            }
        }
        @media (max-width: 480px) {
            .container {
                padding: 10px;
            }
            .scrollable-div {
                padding: 5px;
            }
            th, td {
                padding: 5px;
            }
        }
    </style>


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card prod-p-card card-red">
                                <div class="card-body">
                                    <div class="row align-items-center m-b-30">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white">Total Available Service</h6>
                                            <h3 class="m-b-0 f-w-700 text-white">{{ $services }}</h3>
                                        </div>
                                        <div class="col-auto">
                                            <i class="far fa-calendar-check text-c-red f-18"></i>
                                        </div>
                                    </div>
                                   <!--  <p class="m-b-0 text-white"><span class="label label-danger m-r-10">+11%</span>From
                                        Previous Month</p> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card prod-p-card card-blue">
                                <div class="card-body">
                                    <div class="row align-items-center m-b-30">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white">Total Earning in this Month</h6>
                                            <h3 class="m-b-0 f-w-700 text-white">${{ number_format($currentMonthMonthEarning, 2) }}</h3>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign text-c-blue f-18"></i>
                                        </div>
                                    </div>
                                    <!-- <p class="m-b-0 text-white"><span class="label label-primary m-r-10">+12%</span>From
                                        Previous Month</p> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card prod-p-card card-green">
                                <div class="card-body">
                                    <div class="row align-items-center m-b-30">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white">Total Customer Inquiry</h6>
                                            <h3 class="m-b-0 f-w-700 text-white">{{$totalCustomerInquiriesCount}}</h3>
                                        </div>
                                        <div class="col-auto">
                                            <i class="far fa-calendar-check text-c-green f-18"></i>
                                        </div>
                                    </div>
                                    <!-- <p class="m-b-0 text-white"><span class="label label-success m-r-10">+52%</span>From
                                        Previous Month</p> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card prod-p-card card-yellow">
                                <div class="card-body">
                                    <div class="row align-items-center m-b-30">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white">Pending Custom Inquiry</h6>
                                            <h3 class="m-b-0 f-w-700 text-white">{{count($pendingCustomerInquiries)}}</h3>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-tags text-c-yellow f-18"></i>
                                        </div>
                                    </div>
                                    <!-- <p class="m-b-0 text-white"><span class="label label-warning m-r-10">+52%</span>From
                                        Previous Month</p> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($pendingInquiries)
                    <div class="row">
                        <div class="container">
                            <h5>Pending Inquiries</h5>
                            <div class="scrollable-div">
                                @foreach($pendingInquiries as $key => $inquery)
                                <div class="inquiry">
                                    <p><strong><b>Pending Inquiry 1</b></strong></p>
                                </div>
                                @endforeach
                              <table>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Vehicle</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingInquiries as $key => $inquiry)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ ucwords($inquiry->name) }}</td>
                                            <td>{{ $inquiry->vehicle }}</td>
                                            <td>{{ $inquiry->date }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('inquiries.show', $inquiry->id) }}"
                                                        class="btn btn-primary waves-effect waves-light mr-2 primary-btn">
                                                        <i class="feather icon-eye m-0"></i>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>{{ $inquiry->notes }}</td>
                                        </tr>
                                        @endforeach
                                        <!-- Add more inquiries as needed -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($pendingCustomerInquiries)
                    <div class="row">
                        <div class="container">
                            <h5>Pending Customer Inquiries ({{count($pendingCustomerInquiries)}})</h5>
                            <div class="scrollable-div">
                                <!-- @foreach($pendingCustomerInquiries as $key => $inquery)
                                <div class="inquiry">
                                    <p><strong><b>Pending Inquiry {{$key + 1}}</b></strong></p>
                                </div>
                                @endforeach -->
                              <table>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Customer Name</th>
                                            <th>Inquiry Status</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingCustomerInquiries as $key => $inquiry)
                                        <tr>
                                           <td>{{ ++$key }}</td>
                                            <td>{{ ucwords($inquiry->customer_name) }}</td>
                                            @if($inquiry->inquiry_status == 'pending')
                                            <td style="color:blue">{{ ucfirst($inquiry->inquiry_status) }}</td>
                                            @elseif($inquiry->inquiry_status == 'in_process')
                                            <td style="color:#ff6a00">In Process</td>
                                            @elseif($inquiry->inquiry_status == 'closed')
                                            <td style="color:green">{{ ucfirst($inquiry->inquiry_status) }}</td>
                                            @elseif($inquiry->inquiry_status == 'failed')
                                            <td style="color:red">{{ ucfirst($inquiry->inquiry_status) }}</td>
                                            @endif
                                            <td>{{ date('d-m-Y h:i a', strtotime($inquiry->inquiry_created_at)) }}</td>
                                            @canany(['edit customer inquiry', 'delete customer inquiry'])
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    @if(Auth::user()->can('edit customer inquiry'))
                                                        <a href="{{ route('customer-inquiry.edit', $inquiry->id) }}"
                                                            class="btn btn-primary primary-btn waves-effect waves-light mr-2">
                                                            <i class="feather icon-edit m-0"></i>
                                                        </a>
                                                    @endif
                                                    @if(Auth::user()->can('delete customer inquiry'))
                                                        <button data-source="Customer Inquiry" data-endpoint="{{ route('customer-inquiry.destroy', $inquiry->id) }}"
                                                            class="delete-btn primary-btn btn btn-danger waves-effect waves-light">
                                                            <i class="feather icon-trash m-0"></i>
                                                        </button>
                                                    @endif 
                                                    </div>
                                            </td>
                                            @endcanany
                                        </tr>
                                        @endforeach
                                        <!-- Add more inquiries as needed -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
            </div>
        </div>
    </div>
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/widget.css') }}">
@endsection

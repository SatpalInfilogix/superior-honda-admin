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
                            @if (session('error'))
                                <x-alert message="{{ session('error') }}"></x-alert>
                            @endif

                            @if (session('import_errors'))
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach (session('import_errors') as $error)
                                            <li>
                                                @foreach ($error['errors'] as $field => $messages)
                                                    <strong>Row {{ $loop->parent->index + 1 }}:</strong>
                                                    @foreach ($messages as $message)
                                                        {{ $message }}<br>
                                                    @endforeach
                                                @endforeach
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card">
                                <div class="card-header">
                                    <h5>Customer Inquiry</h5>
                                    <div class="float-right">
                                        <select class="form-control" name="branch" id="branch">
                                            
                                            @if(!empty($branches))
                                                @php
                                                    $branch_selected = !empty($selected_branch_id) ? $selected_branch_id : Auth::user()->branch_id;
                                                @endphp
                                                <option value="all" {{ 'all' == $branch_selected ? 'selected' : ''}}>All Branches</option>
                                                @foreach($branches as $branch)
                                                    <option value="{{$branch->id}}" {{ $branch->id == $branch_selected ? 'selected' : ''}}>{{$branch->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <form id="inquiryFilterForm" method="GET" action="{{ route(request()->route()->getName(), $selected_branch_id) }}" class="mb-3">
                                            <div class="row mr-0">
                                                <div class="col-md-3">
                                                    <input type="number" name="mobile" class="form-control" placeholder="Mobile Number" value="{{ request('mobile') }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <select name="status"  class="form-control">
                                                        <option value="" selected>Select Status</option>
                                                        <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                                                        <option value="in_process" @selected(request('status') == 'in_process')>Processing</option>
                                                        <option value="closed" @selected(request('status') == 'closed')>Closed</option>
                                                        <option value="failed" @selected(request('failed') == 'cancelled')>Cancelled</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" id="datepicker" name="date" class="form-control" placeholder="Select Date (2001-01-01)" value="{{ request('date') }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-primary primary-btn custom">Filter</button>
                                                    <a href="{{ route(request()->route()->getName(),$selected_branch_id) }}" class="btn btn-secondary custom">Reset</a>
                                                </div>
                                            </div>
                                        </form>
                                        <table id="customer-inquiry" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Customer Name</th>
                                                    <th>Inquiry Status</th>
                                                    <th>Date</th>
                                                    @canany(['edit customer inquiry', 'delete customer inquiry'])
                                                    <th>Actions</th>
                                                    @endcanany
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!empty($final_customer_enquiry_data))
                                                    @foreach ($final_customer_enquiry_data as $key => $customer_inquiry)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ ucfirst($customer_inquiry->customer_name) ?? '' }}</td>
                                                            @if($customer_inquiry->inquiry_status == 'pending')
                                                            <td style="color:blue">{{ ucfirst($customer_inquiry->inquiry_status) ?? ''}}</td>
                                                            @elseif($customer_inquiry->inquiry_status == 'in_process')
                                                            <td style="color:#ff6a00">In Process</td>
                                                            @elseif($customer_inquiry->inquiry_status == 'closed')
                                                            <td style="color:green">{{ ucfirst($customer_inquiry->inquiry_status ?? '') }}</td>
                                                            @elseif($customer_inquiry->inquiry_status == 'failed')
                                                            <td style="color:red">{{ ucfirst($customer_inquiry->inquiry_status) ?? ''}}</td>
                                                            @endif
                                                            <td>{{ date('d-m-Y h:i a', strtotime($customer_inquiry->inquiry_created_at)) ?? '' }}</td>
                                                            @canany(['edit customer inquiry', 'delete customer inquiry'])
                                                            <td>
                                                                <div class="btn-group btn-group-sm">
                                                                    @if(Auth::user()->can('edit customer inquiry'))
                                                                        <a href="{{ route('customer-inquiry.edit', $customer_inquiry->id ?? '') }}"
                                                                            class="btn btn-primary primary-btn waves-effect waves-light mr-2">
                                                                            <i class="feather icon-edit m-0"></i>
                                                                        </a>
                                                                    @endif

                                                                    @if($customer_inquiry->status == 'active')
                                                                        <button
                                                                            class="disable-customer-inquiry btn btn-primary primary-btn waves-effect waves-light mr-2"
                                                                            data-id="{{ $customer_inquiry->id }}" data-value="enabled">
                                                                            <i class="feather icon-check-circle m-0"></i>
                                                                        </button>
                                                                    @else
                                                                        <button
                                                                            class="disable-customer-inquiry btn btn-primary primary-btn waves-effect waves-light mr-2"
                                                                            data-id="{{ $customer_inquiry->id }}" data-value="disabled">
                                                                            <i class="feather icon-slash m-0"></i>
                                                                        </button>
                                                                    @endif
                                                                    @if(Auth::user()->can('delete customer inquiry'))
                                                                        <button data-source="Customer Inquiry" data-endpoint="{{ route('customer-inquiry.destroy', $customer_inquiry->id) }}"
                                                                            class="delete-btn primary-btn btn btn-danger waves-effect waves-light">
                                                                            <i class="feather icon-trash m-0"></i>
                                                                        </button>
                                                                    @endif 
                                                                </div>
                                                            </td>
                                                            @endcanany
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-include-plugins dataTable></x-include-plugins>

    <script>
        $(function() {
            $('#datepicker').datepicker({
                autoclose: true,
                format: 'mm-dd-yyyy' 
            });
            document.getElementById('inquiryFilterForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            const form = event.target;
            const formData = new FormData(form);
            const queryParams = new URLSearchParams();
        
            formData.forEach((value, key) => {
                if (value.trim() !== '') {
                    queryParams.append(key, value);
                }
            });
        
                window.location.href = form.action + '?' + queryParams.toString();
            });


            $('#customer-inquiry').DataTable();

            $(document).on('click', '.disable-customer-inquiry', function() {
                var id = $(this).data('id');
                var value = $(this).data('value');
                swal({
                    title: "Are you sure?",
                    text: `You really want to ${value == 'enabled' ? 'disabled' : 'enabled'} ?`,
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                }, function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: '{{ route("disable-customer-inquiry") }}',
                            method: 'post',
                            data: {
                                id: id,
                                disable_customer_inquiry: value,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if(response.success){
                                    swal({
                                        title: "Success!",
                                        text: response.message,
                                        type: "success",
                                        showConfirmButton: false
                                    }) 

                                    setTimeout(() => {
                                        location.reload();
                                    }, 2000);
                                }
                            }
                        })
                    }
                });
            })
        });

        $(document).ready(function () {
            $("#branch").change(function () {
                var branchId = $(this).val();
                if (branchId) {
                    window.location.href = "/customer-inquiry/branch/" + branchId;
                }
            });
        });
    </script>
@endsection
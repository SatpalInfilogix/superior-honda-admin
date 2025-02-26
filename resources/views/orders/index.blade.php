@extends('layouts.app')

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="row">
                        <div class="col-sm-12">
                            <div id="success-message" class="alert-success text-success f-12" style="display: none;"></div>

                            @if (session('success'))
                                <x-alert message="{{ session('success') }}"></x-alert>
                            @endif
                            @if (session('error'))
                                @foreach (session('error') as $key => $error)
                                    @foreach ($error as $errorKey => $value)
                                        <x-alert type="error" message="{{ $value }}"></x-alert>
                                    @endforeach
                                @endforeach
                            @endif
                            
                            <div class="card">
                                <div class="card-header">
                                    <h5>Orders</h5>
                                    <div class="float-right">
                                        {{-- @can('create customer')
                                            <a href="{{ route('customers.create') }}" class="btn btn-primary btn-md primary-btn">Add
                                                customer</a>
                                        @endif --}}
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <form id="orderFilterForm" method="GET" action="{{ route('orders.index') }}" class="mb-3">
                                            <div class="row mr-0">
                                                <div class="col-md-2">
                                                    <input type="text" name="order_id" class="form-control" placeholder="Order ID" value="{{ request('order_id') }}">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="mobile" class="form-control" placeholder="Mobile Number" value="{{ request('mobile') }}">
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="order_status"  class="form-control">
                                                        <option value="" selected>Select Status</option>
                                                        <option value="pending" @selected(request('order_status') == 'pending')>Pending</option>
                                                        <option value="processing" @selected(request('order_status') == 'processing')>Processing</option>
                                                        <option value="completed" @selected(request('order_status') == 'completed')>Completed</option>
                                                        <option value="cancelled" @selected(request('order_status') == 'cancelled')>Cancelled</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-primary primary-btn custom">Filter</button>
                                                    <a href="{{ route('orders.index') }}" class="btn btn-secondary custom">Reset</a>
                                                </div>
                                            </div>
                                        </form>
                                        <table id="order-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone Number</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $key => $order)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ optional($order['billingAddress'])->first_name .' '. optional($order['billingAddress'])->last_name }}</td>
                                                        <td>{{ $order['email'] }}</td>
                                                        <td>{{ $order['phone_number'] }}</td>
                                                        <td>
                                                            <select name="status" class="btn btn-secondary dropdown-toggle status-dropdown" data-id="{{ $order['id'] }}">
                                                                <option value="pending" {{ $order['status'] == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                <option value="processing" {{ $order['status'] == 'processing' ? 'selected' : '' }}>Processing</option>
                                                                <option value="completed" {{ $order['status'] == 'completed' ? 'selected' : '' }}>Completed</option>
                                                                <option value="cancelled" {{ $order['status'] == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <button type="button"
                                                                    class="btn btn-primary primary-btn waves-effect waves-light mr-2"
                                                                    data-toggle="modal"
                                                                    data-target="#wishlistModal{{ $key }}">
                                                                    <i class="feather icon-eye m-0"></i>
                                                                </button>
                                                            </div>
                                                            {{-- <a href="{{ route('orders.show', $order['id']) }}"
                                                                class="btn btn-primary waves-effect waves-light mr-2 primary-btn">
                                                                <i class="feather icon-eye m-0"></i>
                                                            </a>   --}}
                                                        </td>
                                                    </tr>
                                                @endforeach
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
    @foreach ($orders as $key => $order)
        <?php 
            $address1 = $order->billingAddress;
            $address2 = $order->shippingAddress;
        ?>
        <div class="modal fade" id="wishlistModal{{ $key }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 148%">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <p><h4>Billing Address:</h4>
                                    {{$address1->first_name .' '.$address1->last_name}} <br>
                                    {{$address1->address}},<br>
                                    {{$address1->city}},{{optional($address1)->state_name}},
                                    {{optional($address1)->country_name}}
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <p><h4>Shipping Address:</h4>
                                    {{$address2->first_name.' '.$address2->last_name}} <br>
                                    {{$address2->address}},<br>
                                    {{$address1->city}}, {{optional($address2)->state_name}}
                                    {{optional($address2)->country_name}}
                                </p>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr style="line-height: 1%;"> 
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Product code</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $cartProducts = json_decode($order['cart_items']);
                                @endphp
                                @if(count($cartProducts->products) > 0)
                                    @foreach ($cartProducts->products as $key => $cart)
                                        <tr style="line-height: 1%;">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $cart->name }}</td>
                                            <td>{{ $cart->product_code }}</td>
                                            <td>{{ $cart->quantity }}</td>
                                            <td>{{ '$'.number_format($cart->price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                @else 
                                    <tr>
                                        <td colspan="4" class="text-center">Order is empty</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6" style="text-align: right">
                                NonTax Total: {{ $cartProducts->formatted_sub_total }}<br>
                                Discount %: {{ optional($cartProducts->applied_coupons)['discount_amount'] }}<br>
                                Sub-Total : {{ $cartProducts->formatted_grand_total }}<br>
                                Tax (18%) : {{ number_format($cartProducts->grand_total * 0.18, 2) }} <br>
                                Total: {{ number_format($cartProducts->grand_total + ($cartProducts->grand_total * 0.18), 2) }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <script>
        document.getElementById('orderFilterForm').addEventListener('submit', function(event) {
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
        $(function() {
            $('#order-list').DataTable();
        })

        $(document).ready(function () {
            $('.status-dropdown').change(function () {
                var status = $(this).val();
                var orderId = $(this).data('id');
                $.ajax({
                    url: '{{route("update-status")}}',
                    method: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        status: status,
                        orderId: orderId
                    },
                    success: function (response) {
                        if(response.success){
                            $('#success-message').html(response.message);
                            $('#success-message').show();
                            setTimeout(function() {
                                $('#success-message').fadeOut('slow');
                            }, 3000);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endsection
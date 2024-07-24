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
                                <h5>Order Detail</h5>
                                <div class="float-right">
                                    <a href="{{ route('orders.index') }}" class="btn btn-primary primary-btn btn-md">Back</a>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <?php
                                            $cartProducts = json_decode($order->cart_items);
                                            $billingAddress = json_decode($order->billing_address);
                                            $country = App\Models\Country::find($billingAddress->country_id)->name;
                                            $state = App\Models\State::find($billingAddress->state_id)->name;
                                            $shippingAddress = json_decode($order->shipping_address);
                                            $shippingCountry = App\Models\Country::find($shippingAddress->country_id)->name;
                                            $shippingState = App\Models\State::find($shippingAddress->state_id)->name;

                                        ?>
                                        <p><label class="font-bold">Name:</label>  {{$order->user ? $order->user->first_name .' '. $order->user->last_name : optional($billingAddress)->first_name.' '.  optional($billingAddress)->last_name}}</p>
                                        <p><label class="font-bold">Phone Number:</label> {{optional($order)->phone_number}}</p>
                                    </div>
                                    <div class="col-sm-3">
                                        <p><label class="font-bold">Billing Address:</label></p>
                                            <p>{{ $billingAddress->address, $billingAddress->city}}</p>
                                            <p>{{ $state. ','. $country.', '. $billingAddress->postal_code }}</p>
                                    </div>
                                    <div class="col-sm-3">
                                        <p><label class="font-bold"> Shipping Address:</label></p>
                                        <p>{{$shippingAddress->address, $shippingAddress->city}}</p>
                                        <p>{{$shippingState.','.$shippingCountry.', '.$shippingAddress->postal_code }} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            
                            <div class="card-block">
                                <div class="dt-responsive table-responsive">
                                    <table id="cart-list" class="table table-striped table-bordered nowrap">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product Name</th>
                                                <th>Product code</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                           @foreach ($cartProducts->products as $key => $cart)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $cart->name }}</td>
                                                    <td>{{ $cart->product_code }}</td>
                                                    <td>{{ $cart->quantity }}</td>
                                                    <td>{{ '$'.number_format($cart->price, 2) }}</td>
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

<script>
    $(function() {
        $('#cart-list').DataTable();
    })
</script>


@endsection
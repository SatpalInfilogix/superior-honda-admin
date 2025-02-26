<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Order::with('user')->latest();
        if ($request->filled('order_id')) {
            $orders->where('order_id', $request->order_id);
        }
        if ($request->filled('mobile')) {
            $orders->where('phone_number', $request->mobile);
        }
        if ($request->filled('order_status')) {
            $orders->where('status', $request->order_status);
        }
        if ($request->filled('date')) {
            $orders->whereDate('created_at', $request->date);
        }
        $orders = $orders->get();

        foreach($orders as $key => $order){
            $billingAddress = json_decode($order->billing_address);
            $shippingAddress = json_decode($order->shipping_address);
            $countryBillingAddress = Country::find($billingAddress->country_id);
            if ($countryBillingAddress) {
                $billingAddress->country_name = $countryBillingAddress->name;
            }

            $stateBillingAddress = State::find($billingAddress->state_id);
            if ($stateBillingAddress) {
                $billingAddress->state_name = $stateBillingAddress->name;
            }

            $countryShippingAddress = Country::find($shippingAddress->country_id);
            if ($countryShippingAddress) {
                $shippingAddress->country_name = $countryShippingAddress->name;
            }

            $stateShippingAddress = State::find($shippingAddress->state_id);
            if ($stateShippingAddress) {
                $shippingAddress->state_name = $stateShippingAddress->name;
            }

            $orders[$key]->billingAddress = $billingAddress;
            $orders[$key]->shippingAddress = $shippingAddress;
        }

        return view('orders.index', compact('orders'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order = Order::with('user')->where('id', $order->id)->first();

        return view('orders.view', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function statusUpdate(Request $request)
    {
        $order= Order::where('id', $request->orderId)->first();
        $order->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.'
        ]);
    }
}

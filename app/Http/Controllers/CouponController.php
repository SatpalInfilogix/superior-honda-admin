<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::latest()->get();

        return view('coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'coupon_code'     => 'required',
            'discount_type'    => 'required',
            'discount_amount'  => 'required'
        ]);

        Coupon::create([
            'coupon_code'     => $request->coupon_code,
            'discount_type'   => $request->discount_type,
            'discount_amount' => $request->discount_amount,
            'start_date'      => $request->start_date,
            'end_date'        => $request->end_date,
        ]);

        return redirect()->route('coupons.index')->with('success', 'Coupon created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        return view('coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'coupon_code'     => 'required',
            'discount_type'    => 'required',
            'discount_amount'  => 'required'
        ]);

        $coupon = Coupon::where('id', $coupon->id)->first();

        $coupon->update([
            'coupon_code'    => $request->coupon_code,
            'discount_type'   => $request->discount_type,
            'discount_amount' => $request->discount_amount,
            'start_date'      => $request->start_date,
            'end_date'        => $request->end_date,
        ]);

        return redirect()->route('coupons.index')->with('success', 'Coupon updated successfully.');            
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon = Coupon::where('id', $coupon->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Coupon deleted successfully.'
        ]);
    }
}

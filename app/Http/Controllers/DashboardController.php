<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Inquiry;
use App\Models\Order;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = new Order();
        $completedOrdersCount = count($order->getCompletedOrders());
        // dd($completedOrders);
        $ordersInQueueCount = count($order->getOrdersInQueue());
        $pendingInquiries = Inquiry::inProgressForThreeHoursOrMore()->get();
        return view('dashboard')->with(
                                        [
                                            'pendingInquiries'     => $pendingInquiries,
                                            'completedOrdersCount' => $completedOrdersCount,
                                            'ordersInQueueCount'   => $ordersInQueueCount
                                        ]
                                    );
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Inquiry;
use App\Models\CustomerInquiry;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use App\Models\Invoice;
use Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = new Order();
        $completedOrdersCount = count($order->getCompletedOrders());
        $ordersInQueueCount = count($order->getOrdersInQueue());
        $pendingInquiries = Inquiry::inProgressForThreeHoursOrMore()->get();
        $pendingCustomerInquiries = CustomerInquiry::inProgressForTwoHoursOrMore()->get();
        $totalCustomerInquiriesCount = CustomerInquiry::where('deleted_at', NULL)->where('status', '!=', 'delete')->count();
        $services = Product::whereNull('deleted_at')->where('is_service', 1)->with('productCategory')->whereHas('productCategory', function ($query) {
            $query->whereNull('deleted_at');
        })->count();

        $currentMonthInvoices = Invoice::whereMonth('created_at', Carbon::now()->month)
                                 ->whereYear('created_at', Carbon::now()->year)
                                 ->get();
        $totalInvoiceAmount = 0;

        foreach ($currentMonthInvoices as $key => $invoice) {
            if ($invoice->type === "order") {
                $cartItems = json_decode(optional($invoice->order)->cart_items, true);
                $currentAmount = 0;
                $totalProducts = 0;
        
                if (is_array($cartItems) && isset($cartItems['products'])) {
                    foreach ($cartItems['products'] as $product) {
                        $totalProducts += $product['quantity'];
                        $currentAmount += $product['price'] * $product['quantity'];
                    }
                }
        
                $currentMonthInvoices[$key]['totalAmount'] = $currentAmount;
                $totalInvoiceAmount += $currentAmount;
        
            } else {
                $productDetails = json_decode(optional($invoice)->product_details);
                $currentAmount = 0; // Initialize current amount for this invoice
                $totalProducts = 0;
        
                if (isset($productDetails->products) && is_array($productDetails->products)) {
                    foreach ($productDetails->products as $value) {
                        $currentAmount += $value->discounted_price ?? $value->price; // Use discounted price if available
                        $totalProducts++; // Increment product count
                    }
                }
                
                $currentMonthInvoices[$key]['totalAmount'] = $currentAmount;
        
                // Add to the overall total amount
                $totalInvoiceAmount += $currentAmount;
            }
        }

        return view('dashboard')->with(
                                        [
                                            'currentMonthMonthEarning' => $totalInvoiceAmount,
                                            'services'             => $services,
                                            'pendingInquiries'     => $pendingInquiries,
                                            'completedOrdersCount' => $completedOrdersCount,
                                            'ordersInQueueCount'   => $ordersInQueueCount,
                                            'pendingCustomerInquiries' => $pendingCustomerInquiries,
                                            'totalCustomerInquiriesCount' => $totalCustomerInquiriesCount
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

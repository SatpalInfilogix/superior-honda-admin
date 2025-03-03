<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Job;
use App\Models\Product;
use App\Models\User;
use App\Models\Service;
use App\Models\Inspection;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::with('order')->latest();
        if ($request->filled('invoice_no')) {
            $invoices->where('invoice_no', 'like', '%' . $request->invoice_no . '%');
        }
        if ($request->filled('customer_name')) {
            $invoices->whereHas('user', function ($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request->customer_name . '%');
            });
        }
        if ($request->filled('mobile')) {
            $invoices->whereHas('user', function ($query) use ($request) {
                $query->where('phone_number', $request->mobile);
            });
        }
        if ($request->filled('date')) {
            $invoices->whereDate('created_at', $request->date);
        }
        $invoices = $invoices->get();
        foreach ($invoices as $key => $invoice) {
            if ($invoice->type === "order") {  // Use '===' for comparison
                $invoices[$key]['billingAddress'] = json_decode(optional($invoice->order)->billing_address, true);
                $invoices[$key]['shippingAddress'] = json_decode(optional($invoice->order)->shipping_address, true);
                $cartItems = json_decode(optional($invoice->order)->cart_items, true);
                $invoices[$key]['cart_items'] = $cartItems;
    
                $totalProducts = 0;
                $totalAmount = 0;
                if (is_array($cartItems) && isset($cartItems['products'])) {
                    foreach ($cartItems['products'] as $product) {
                        $totalProducts += $product['quantity'];
                        $totalAmount += $product['price'] * $product['quantity'];
                    }
                }
    
                // Set totals in the invoice array
                $invoices[$key]['totalProducts'] = $totalProducts;
                $invoices[$key]['totalAmount'] = $totalAmount;
            } else {
                $productDetails = json_decode(optional($invoice)->product_details);
                $invoices[$key]['productDetails'] = $productDetails;
                $totalAmount = 0;
                $totalProducts = 0;
        
                if (isset($productDetails->products) && is_array($productDetails->products)) {
                    foreach ($productDetails->products as $value) {
                        // Assuming the product has a 'discounted_price' or 'price'
                        $totalAmount += $value->discounted_price ?? $value->price; // Use discounted price if available
                        $totalProducts++; // Increment product count
                    }
                }
                $invoices[$key]['totalProducts'] = $totalProducts;
                $invoices[$key]['totalAmount'] = $totalAmount;
            }
        }
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $jobs = Inspection::latest()->get();

        return view('invoices.create', compact('jobs'));
    }

    public function autocomplete(Request $request)
    {
        $searchTerm = $request->input('input');
        $inspectionServices = Inspection::where('id', $request->jobId)->pluck('services')->map(function ($services) {
            return explode(',', $services);
        })->flatten()->unique();

        $matchingServices = Service::where('name', 'like', '%' . $searchTerm . '%') // Adjust 'service_name' if needed
                                    ->whereIn('id', $inspectionServices)->latest()->get();

        $products = Product::whereNull('deleted_at')->with('productCategory')->whereHas('productCategory', function ($query) {
                            $query->whereNull('deleted_at');
                        })->where('product_name', 'like', '%' . $searchTerm . '%')->get(['id', 'product_name']);

        $formattedServices = collect($matchingServices)->map(function ($service) {
            return [
                'id' => $service->id,
                'name' => $service->name, // Adjust if needed
                'type' => 'service',
            ];
        });

        $formattedProducts = collect($products)->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->product_name,
                'type' => 'product',
            ];
        });

        $mergedResults = $formattedServices->merge($formattedProducts);

        return response()->json($mergedResults);
    }

    public function productDetails(Request $request)
    {
        $productName = $request->productName;

        $service = Service::where('name',  $productName)->first();
        $product = Product::where('product_name', $productName)->first();

        $servicePrice = $service ? $service->price : 0;
        $productPrice = $product ? $product->cost_price : 0;

        $totalPrice = $servicePrice + $productPrice;
        return response()->json([
            'success' => true,
            'product' => [
                'price' => $totalPrice,
                // 'discount' => $product->discount,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $jobId = $request->input('job_id');
        $products = $request->input('product');
        $prices = $request->input('price');
        $discounts = $request->input('discount');
        $totalAmount = 0;
        $items = [];
        foreach ($products as $key => $product) {
            $price = (float) $prices[$key];
            $discount = isset($discounts[$key]) ? (float) $discounts[$key] : 0;
    
            // Calculate discounted price
            $discountedPrice = $price * (1 - ($discount / 100));
            $totalAmount += $discountedPrice;
    
            // Prepare item for storing or further processing
            $items['products'][$key] = [
                'product' => $product,
                'price' => $price,
                'discount' => $discount,
                'discounted_price' => $discountedPrice,
            ];
            
        }
        $items['totalAmount'] = $totalAmount;

        $invoice = Invoice::orderByDesc('invoice_no')->first();
        if (!$invoice) {
            $invCode =  'INV0001';
        } else {
            $numericPart = (int)substr($invoice->invoice_no, 3);
            $nextNumericPart = str_pad($numericPart + 1, 4, '0', STR_PAD_LEFT);
            $invCode = 'INV' . $nextNumericPart;
        }

        Invoice::create([
            'invoice_no'=> $invCode,
            'product_Details' => json_encode($items),
            'job_id'          => $request->job_id,
            'type'            => 'job'
        ]);

        return redirect()->route('invoices.index')->with('success', 'Invoice saved successfully');
    }

    public function edit(Invoice $invoice)
    {
        $jobs = Inspection::latest()->get();
        $products = Product::whereNull('deleted_at')->latest()->get();

        return view('invoices.edit', compact('invoice', 'jobs', 'products'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $jobId = $request->input('job_id');
        $products = $request->input('product');
        $prices = $request->input('price');
        $discounts = $request->input('discount');
        $totalAmount = 0;
        $items = [];
        foreach ($products as $key => $product) {
            $price = (float) $prices[$key];
            $discount = isset($discounts[$key]) ? (float) $discounts[$key] : 0;

            // Calculate discounted price
            $discountedPrice = $price * (1 - ($discount / 100));
            $totalAmount += $discountedPrice;

            // Prepare item for storing or further processing
            $items['products'][$key] = [
                'product' => $product,
                'price' => $price,
                'discount' => $discount,
                'discounted_price' => $discountedPrice,
            ];
        }
        $items['totalAmount'] = $totalAmount;

        $invoice = Invoice::where('id', $invoice->id)->update([
            'product_Details' => json_encode($items),
            'job_id'          => $request->job_id,
            'type'            => 'job'
        ]);

        return redirect()->route('invoices.index')->with('success', 'Invoice saved successfully');
    }

    public function downloadInvoicePdf($id){
        $invoice = Invoice::with('order')->where('id', $id)->first();
        if ($invoice) {
            if ($invoice->type == "order") {
                $invoice['billingAddress'] = json_decode(optional($invoice->order)->billing_address, true);
                $invoice['shippingAddress'] = json_decode(optional($invoice->order)->shipping_address, true);
                $invoice['cart_items'] = json_decode(optional($invoice->order)->cart_items, true);
            } else {
                $invoice['productDetails'] = json_decode(optional($invoice)->product_details, true);
            }

            // print_r($invoiceData);
            // die;

            $pdf = PDF::loadView('invoices.invoice', ['invoice' => $invoice]);

            return $pdf->download('invoice-' . $id . '.pdf');
        } else {
            // Handle the case where the invoice is not found
            return response()->json(['message' => 'Invoice not found'], 404);
        }
    }

    public function getServicesByJob(Request $request)
    {
        $response = [
            'items' => [],
            'totalAmount' => 0,
        ];
        
        $jobId = $request->input('job_id');
    
        $invoice = Invoice::where('id', $request->invoice_id)->where('job_id', $jobId)->first();
        if ($invoice && !empty($invoice->product_details)) {
            $productDetails = json_decode($invoice->product_details);
            
            foreach ($productDetails->products as $value) {
                $discountedPrice = $value->discounted_price ?? 0; // Use null coalescing
                $productItem = [
                    'name' => $value->product ?? '',
                    'price' => $value->price ?? 0,
                    'discount' => $value->discount ?? 0,
                    'discounted_price' => $discountedPrice,
                ];
                
                // Add product to response if it doesn't already exist
                if (!isset($response['items'][$productItem['name']])) {
                    $response['items'][$productItem['name']] = $productItem;
                    $response['totalAmount'] += $discountedPrice;
                }
            }
        }
    
        $inspection = Inspection::where('id', $jobId)->first();
        $serviceIds = [];
        if (!empty($inspection->services)) {
            $serviceIds = explode(',', $inspection->services);
        }
        
        $services = Service::whereIn('id', $serviceIds)
                ->select('id', 'name', 'price')
                ->get();
    
        foreach ($services as $service) {
            $serviceItem = [
                'name' => $service->name,
                'price' => $service->price,
                'discount' => 0, // Assuming no discount for services
                'discounted_price' => 0, // Same as price if no discount
            ];
            
            if (!isset($response['items'][$serviceItem['name']])) {
                $response['items'][$serviceItem['name']] = $serviceItem;
                $response['totalAmount'] += $service->price; // Add service price to total
            }
        }
    
        $response['items'] = array_values($response['items']);
    
        return response()->json($response); // Return the structured response
    }

    public function printInvoiceList()
    {
        $invoices = Invoice::whereNull('order_id')->latest()->get();
    
        // Prepare an array to hold the totals
        $invoiceDetails = [];
    
        foreach ($invoices as $key => $invoice) {
            $productDetails = json_decode($invoice->product_details);
    
            // Initialize totals for this invoice
            $totalAmount = 0;
            $totalProducts = 0;
    
            if (isset($productDetails->products) && is_array($productDetails->products)) {
                foreach ($productDetails->products as $value) {
                    $totalAmount += $value->discounted_price ?? $value->price; // Use discounted price if available
                    $totalProducts++; // Increment product count
                }
            }
    
            $invoices[$key] = [
                'invoice_no'  => $invoice->invoice_no,
                'totalAmount' => $totalAmount,
                'totalProducts' => $totalProducts,
            ];
        }
    
        return view('invoices.print.invoice-list', compact('invoices', 'invoiceDetails'));
    }

    public function printInvoice($id)
    {
        $invoices = Invoice::where('id', $id)->first();
        return view('invoices.print.invoice-detail', compact('invoices'));
    }
    
    public function userAutocomplete(Request $request)
    {
        $parts = explode(' ', $request->input('input'), 2); 
        $firstName = $parts[0]; 
        $lastName = $parts[1] ?? ''; 
        
        $users = User::where('first_name', 'like', '%' . $firstName . '%')
            ->where('last_name', 'like', '%' . $lastName . '%')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'customer'); // Filtering users with "customer" role
            })
            ->get(['id', 'first_name', 'last_name']);
        
        return response()->json($users);
    }
}

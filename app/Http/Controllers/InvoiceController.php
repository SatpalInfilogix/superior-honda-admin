<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Job;
use App\Models\Product;
use App\Models\Service;
use App\Models\Inspection;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('order')->latest()->get();
        foreach($invoices as $key => $invoice) {
            if($invoice->type="order") {
                $invoices[$key]['billingAddress'] = json_decode(optional($invoice->order)->billing_address, true);
                $invoices[$key]['shippingAddress'] = json_decode(optional($invoice->order)->shipping_address, true);
                $invoices[$key]['cart_items'] = json_decode(optional($invoice->order)->cart_items, true);
            } else {
                $invoices[$key]['productDetails'] = json_decode(optional($invoice)->product_details, true);
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
        $inspectionServices = Inspection::pluck('services')->map(function ($services) {
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
        $jobs = Job::latest()->get();
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

}

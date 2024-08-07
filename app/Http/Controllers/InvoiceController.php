<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Job;
use App\Models\Product;
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
        $jobs = Job::latest()->get();
        $products = Product::latest()->get();

        return view('invoices.create', compact('jobs', 'products'));
    }

    public function autocomplete(Request $request)
    {
        $searchTerm = $request->input('input');
        $products = Product::with('productCategory')->whereHas('productCategory', function ($query) {
                            $query->whereNull('deleted_at');
                        })->where('product_name', 'like', '%' . $searchTerm . '%')->get(['id', 'product_name']);

        return response()->json($products);
    }

    public function productDetails(Request $request)
    {
        $productId = $request->id;

        $product = Product::where('id', $productId)->first();

        return response()->json([
            'success' => true,
            'product' => [
                'price' => $product->cost_price,
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
        $products = Product::latest()->get();

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

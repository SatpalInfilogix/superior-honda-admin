<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesProduct;
use App\Models\Product;

class SalesProductController extends Controller
{
    public function index()
    {
        $salesProducts = SalesProduct::with('product')->get();

        return view('sales-product.index', compact('salesProducts'));
    }

    public function create()
    {
        return view('sales-product.create');
    }

    public function store(Request $request)
    {
        $products =  Product::where('product_name', $request->product)->first();

        if ($products) {
            SalesProduct::create([
                'product_id'    => $products->id,
                'start_date'    => $request->start_date,
                'end_date'      => $request->end_date
            ]);

            return redirect()->route('sales-products.index')->with('success', 'Sales product saved successfully.'); 
        } else {
            return redirect()->route('sales-products.index')->with('error', 'Sales product not found.'); 
        }
    }

    public function destroy(string $id)
    {
        SalesProduct::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sales product deleted successfully.'
        ]);
    }
}

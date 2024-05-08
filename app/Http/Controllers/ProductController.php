<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\VehicleCategory;
use App\Models\VehicleModel;
use App\Models\VehicleBrand;
use App\Models\VehicleType;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Gate::allows('view product')) {
            abort(403);
        }
        $products = Product::latest()->get();

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Gate::allows('create product')) {
            abort(403);
        }

        $categories = VehicleCategory::all();

        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Gate::allows('create product')) {
            abort(403);
        }

        $request->validate([
            'category_id'  => 'required',
            'product_name' => 'required',
            'manufacture_name' => 'required'
        ]);

        Product::create([
            'product_name'  => $request->product_name,
            'category_id'   =>$request->category_id,
            'brand_id'      =>$request->brand_name,
            'model_id'      => $request->model_name,
            'type_id'       => $request->vehicle_type,
            'manufacture_name' => $request->manufacture_name,
            'supplier'      => $request->supplier,
            'quantity'      => $request->quantity,
            'hsn_no'        => $request->hsn_no
        ]);

        return redirect()->route('products.index')->with('success', 'Product saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        if(!Gate::allows('edit product')) {
            abort(403);
        }

        $categories = VehicleCategory::all();
        $brands = VehicleBrand::all();
        $vehicleModels = VehicleModel::all();
        $vehicleTypes = VehicleType::all();

        return view('products.edit', compact('product', 'categories', 'brands', 'vehicleModels', 'vehicleTypes'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        
        if(!Gate::allows('edit product')) {
            abort(403);
        }

        $request->validate([
            'category_id'  => 'required',
            'product_name' => 'required',
            'manufacture_name' => 'required'
        ]);

        $product = Product::where('id', $product->id)->first();

        $product->update([
            'product_name'  => $request->product_name,
            'category_id'   => $request->category_id,
            'brand_id'      => $request->brand_name,
            'model_id'      => $request->model_name,
            'type_id'       => $request->vehicle_type,
            'manufacture_name' => $request->manufacture_name,
            'supplier'      => $request->supplier,
            'quantity'      => $request->quantity,
            'hsn_no'        => $request->hsn_no
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if(!Gate::allows('delete product')) {
            abort(403);
        }

        $product = Product::where('id', $product->id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully.'
        ]);
    }
}

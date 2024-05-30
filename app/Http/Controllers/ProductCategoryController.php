<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ProductCategory::all();
        return view('product-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Gate::allows('create product')) {
            abort(403);
        }
        return view('product-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:product_categories|max:25'
        ]);
        if($request->hasfile('image')){

            $file = $request->file('image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/product-categories-image/'), $filename);

            $category = new ProductCategory();
            $category->name = $request->name;
            $category->category_image = 'uploads/product-categories-image/'. $filename;
            $category->save();
        
            return redirect()->route('product-categories.index')->with('success', 'Product category saved successfully');
        }    
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
        if(!Gate::allows('edit product')) {
            abort(403);
        }
        $product_category = ProductCategory::find($id); 
        return view('product-categories.edit', compact('product_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = ProductCategory::find($id);

        if($request->hasfile('image')){

            $file = $request->file('image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/product-categories-image/'), $filename);

            $category->name = $request->name;
            $category->category_image = 'uploads/product-categories-image/'. $filename;
            $category->save();

        }else{

            $category->name = $request->name; 

        } 

        $category->save();

        return redirect()->route('product-categories.index')->with('success', 'Product category update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!Gate::allows('delete product')) {
            abort(403);
        }
        ProductCategory::where('id', $id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Product category deleted successfully.'
        ]);
    }
}

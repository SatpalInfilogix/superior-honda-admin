<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory; 
use App\Models\ProductParentCategories;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Str;

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
            'name' => 'required|unique:product_categories|max:25',
            'parent_category_id' => 'required',
        ]);

        if($request->hasfile('image')){

            $file = $request->file('image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/product-categories-image/'), $filename);

            $category = new ProductCategory();
            $category->name = $request->name;
            $category->category_image = 'uploads/product-categories-image/'. $filename;
            $category->product_category_slug = Str::slug($request->name);
            $category->save();

            $parent_categories = $request->parent_category_id;

            foreach($parent_categories as $parent_category)
            {
                $parent_category_data = [];
                $parent_category_data['product_category_id'] = $category->id;
                $parent_category_data['parent_category_name'] = $parent_category;
                
                ProductParentCategories::create($parent_category_data);
            }
        
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
        $product_category = ProductCategory::with('parent_categories')->find($id); 
        return view('product-categories.edit', compact('product_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
           'name' => [
                'required',
                'max:25',
                Rule::unique('product_categories', 'name')->ignore($id)
            ],
            'parent_category_id' => 'required'
        ]);

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
        $category->product_category_slug = Str::slug($request->name);
        $category->save();

        // old parent categories
        $old_parent_categories = ProductParentCategories::where('product_category_id', $id)->get()->pluck('parent_category_name')->toArray();

        // new parent categories
        $new_parent_categories = $request->parent_category_id;

        // categories to add (new but not in old)
        $categories_to_add = array_diff($new_parent_categories, $old_parent_categories);

        // categories to delete (old but not in new)
        $categories_to_delete = array_diff($old_parent_categories, $new_parent_categories);

        // Add new categories
        foreach ($categories_to_add as $category_to_add) {
            ProductParentCategories::create([
                'product_category_id' => $category->id,
                'parent_category_name' => $category_to_add
            ]);
        }

        // Delete removed categories
        foreach ($categories_to_delete as $category_to_delete) {
            ProductParentCategories::where('product_category_id', $product->id)
                ->where('parent_category_name', $category_to_delete)
                ->delete();
        }

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

        $parent_categories = ProductParentCategories::where('product_category_id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product category deleted successfully.'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory; 
use Illuminate\Http\Request;
use App\Models\VehicleCategory;
use App\Models\VehicleModel;
use App\Models\VehicleBrand;
use App\Models\VehicleType;
use App\Models\ProductImage;
use App\Models\VehicleModelVariant;
use App\Models\ParentCategoriesForProducts;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

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
        $products = Product::whereNull('deleted_at')->with('category', 'productCategory')->whereHas('productCategory', function ($query) {
                        $query->whereNull('deleted_at');
                    })->latest()->get();

        // foreach($products as $key=> $product) {
        //     $genertorHTML = new BarcodeGeneratorHTML();
        //     $products[$key]['barcode'] = $genertorHTML->getBarcode($product->product_code. ' ' .$product->product_name, $genertorHTML::TYPE_CODE_128,2);
        // }

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

        $categories = ProductCategory::all();
        $vehicleCategories = VehicleCategory::all();
        return view('products.create', compact('categories', 'vehicleCategories'));
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
            'product_code' => [
                'required',
                Rule::unique('products', 'product_code')->whereNull('deleted_at')
            ],
            'category_id'       => 'required',
            'vehicle_category_id' => 'required',
            'product_name'      => 'required',
            'manufacture_name'  => 'required',
            'parent_category_id' => 'required',
        ]);

        if ($request->hasFile('service_icon'))
        {
            $iconFile = $request->file('service_icon');
            $iconFilename = time().'.'.$iconFile->getClientOriginalExtension();
            $iconFile->move(public_path('uploads/service-icons/'), $iconFilename);
        }

        $product = Product::create([
            'product_code'      => $request->product_code,
            'product_name'      => $request->product_name,
            'category_id'       =>$request->category_id,
            'vehicle_category_id'=> $request->vehicle_category_id,
            'brand_id'          =>$request->brand_name,
            'model_id'          => $request->model_name,
            'varient_model_id'  =>$request->model_variant_name,
            'type_id'           => $request->vehicle_type,
            'manufacture_name'  => $request->manufacture_name,
            'supplier'          => $request->supplier,
            'quantity'          => $request->quantity,
            'hsn_no'            => $request->hsn_no,
            'is_oem'            => $request->oem ?? 0,
            'is_service'        => $request->is_service ?? 0,
            'short_description' => $request->short_description,
            'service_icon'      => isset($iconFilename) ? 'uploads/service-icons/'.$iconFilename : NULL,
            'popular'           => $request->is_popular ?? 0,
            'used_part'         => $request->used_part ?? 0,
            'out_of_stock'         => $request->out_of_stock ?? 0,
            'access_series'     => $request->access_series ?? 0,
            'description'       => $request->description,
            'cost_price'        => $request->cost_price,
            'item_number'       => $request->item_number,
            'created_by'        => Auth::id(),
            'year'              => is_array($request->year_range) ? implode(',', $request->year_range) : NULL
        ]);

        $images = $request->images;
        if ($images) {
            $files = [];
            if($request->hasfile('images'))
            {
                foreach($request->file('images') as $file)
                {
                    $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                    // $filename = time().'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('uploads/product-image/'), $filename);
                    ProductImage::create([
                        'product_id' => $product->id,
                        'images'     => 'uploads/product-image/'. $filename,
                    ]);
                }
            }
        }

        $parent_categories = $request->parent_category_id;

        foreach($parent_categories as $parent_category)
        {
            $parent_category_data = [];
            $parent_category_data['product_id'] = $product->id;
            $parent_category_data['parent_category_name'] = $parent_category;
            
            ParentCategoriesForProducts::create($parent_category_data);
        }

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

        $categories = ProductCategory::all();
        $vehicleCategories = VehicleCategory::all();
        $brands = VehicleBrand::all();
        $vehicleModels = VehicleModel::all();
        $vehicleTypes = VehicleType::all();
        $modelVariants = VehicleModelVariant::all();
        $product = Product::with('images', 'parent_categories')->where('id', $product->id)->first();
        $selectedYears = explode(',', $product->year);
        return view('products.edit', compact('product', 'categories', 'brands', 'vehicleModels', 'vehicleTypes','modelVariants', 'vehicleCategories', 'selectedYears'));

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
            'product_code' => [
                'required',
                Rule::unique('products', 'product_code')->whereNull('deleted_at')->ignore($product->id)
            ],
            'category_id' => 'required',
            'vehicle_category_id' => 'required',
            'product_name' => 'required',
            'manufacture_name' => 'required',
            'parent_category_id' => 'required'
        ]);

        $product = Product::where('id', $product->id)->first();
        $oldServiceIcon = NULL;
        if($product != '') {
            $oldServiceIcon = $product->service_icon;
        }

        if ($request->hasFile('service_icon'))
        {
            $iconFile = $request->file('service_icon');
            $iconFilename = time().'.'.$iconFile->getClientOriginalExtension();
            $iconFile->move(public_path('uploads/service-icons/'), $iconFilename);
        }

        $product->update([
            'product_code'      => $request->product_code,
            'product_name'      => $request->product_name,
            'category_id'       => $request->category_id,
            'vehicle_category_id'=> $request->vehicle_category_id,
            'brand_id'          => $request->brand_name,
            'model_id'          => $request->model_name,
            'varient_model_id'  =>$request->model_variant_name,
            'type_id'           => $request->vehicle_type,
            'manufacture_name'  => $request->manufacture_name,
            'supplier'          => $request->supplier,
            'quantity'          => $request->quantity,
            'hsn_no'            => $request->hsn_no,
            'is_oem'            => $request->oem ?? 0,
            'is_service'        => $request->is_service ?? 0,
            'short_description' => $request->short_description,
            'service_icon'      => isset($iconFilename) ? 'uploads/service-icons/'.$iconFilename : $oldServiceIcon,
            'popular'           => $request->is_popular ?? 0,
            'used_part'         => $request->used_part ?? 0,
            'out_of_stock'         => $request->out_of_stock ?? 0,
            'access_series'     => $request->access_series ?? 0,
            'description'       => $request->description,
            'cost_price'        => $request->cost_price,
            'item_number'       => $request->item_number,
            'year'              => is_array($request->year_range) ? implode(',', $request->year_range) : NULL
        ]);

        if ($request->hasFile('images')) {
            if (count($request->images) > 0) {
                foreach ($request->file('images') as $file) {
                    $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                    // $filename = time().'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('uploads/product-image/'), $filename);
                    $file = ProductImage::create([
                        'product_id' => $product->id,
                        'images'      => 'uploads/product-image/'. $filename,
                    ]);
                }
            }
        }

        $imagesDeleteId = $request->image_id;
        if ($imagesDeleteId[0]) {
            $imagesIds= explode(',',$imagesDeleteId[0]);
            $imageDeleted = ProductImage::whereIn('id', $imagesIds)->delete();
        }

        // old parent categories
        $old_parent_categories = ParentCategoriesForProducts::where('product_id', $product->id)->get()->pluck('parent_category_name')->toArray();

        // new parent categories
        $new_parent_categories = $request->parent_category_id;

        // categories to add (new but not in old)
        $categories_to_add = array_diff($new_parent_categories, $old_parent_categories);

        // categories to delete (old but not in new)
        $categories_to_delete = array_diff($old_parent_categories, $new_parent_categories);

        // Add new categories
        foreach ($categories_to_add as $category_to_add) {
            ParentCategoriesForProducts::create([
                'product_id' => $product->id,
                'parent_category_name' => $category_to_add
            ]);
        }

        // Delete removed categories
        foreach ($categories_to_delete as $category_to_delete) {
            ParentCategoriesForProducts::where('product_id', $product->id)
                ->where('parent_category_name', $category_to_delete)
                ->delete();
        }
        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }


    public function disableProduct(Request $request)
    {
        $product = Product::where('id', $request->id)->first();
        $status = 1;
        $message = 'Product disabled successfully.';
        if($request->disable_product == 'disabled'){
            $status = 1;
            $message = 'Product enabled successfully.';
        }else{
            $status = 0;
            $message = 'Product disabled successfully.';
        }

        Product::where('id', $request->id)->update([
          'status' => $status  
        ]);

        return response()->json([
                'success' => true,
                'message' => $message
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if(!Gate::allows('delete product')) {
            abort(403);
        }

        $product_id = $product->id;
        $product = Product::where('id', $product_id)->delete();
        $parent_categories = ParentCategoriesForProducts::where('product_id', $product_id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully.'
        ]);
    }

    public function getVehicleModelVariant(Request $request)
    {
        $vehicleModelVariants = VehicleModelVariant::where('model_id', $request->model_id)->get();
        $options='<option value="">Select Model Variant</option>';
        foreach($vehicleModelVariants as $modelVariants)
        {
            $options .= '<option value="'.  $modelVariants->id .'">'. $modelVariants->variant_name	 .'</option>';
        }

        return response()->json([
            'options' => $options
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required ',
        ]);

        $import = new ProductImport;

        Excel::import($import, $request->file('file'));

        $errors = $import->getErrors();

        if (!empty($errors)) {
            Session::flash('import_errors', $errors);
            return redirect()->route('products.index')->with('error', 'Some Products could not be imported. Please check the errors.');
        }

        return redirect()->route('products.index')->with('success', 'Products imported successfully.');
    }

    public function downloadExcel()
    {
        $products = Product::whereNull('deleted_at')->with('category', 'productCategory', 'images')->whereHas('productCategory', function ($query) {
            $query->whereNull('deleted_at');
        })->latest()->get();

        $fileName = 'export-products.csv';

        $handle = fopen('php://output', 'w');

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        
        fputcsv($handle, ['product_code', 'category_id', 'product_name', 'manufacture_name', 'supplier', 'quantity', 'vehicle_category_id', 'description', 'cost_price', 'item_number', 'image_paths', 'vehicle_brand_id', 'vehicle_model_id', 'vehicle_variant_id', 'vehicle_type_id', 'is_oem', 'is_Service', 'service_icon', 'short_description', 'is_used_part', 'accesseries','year']);
        $baseImagePath = env('APP_URL');
        foreach ($products as $product) {
            $serviceIcon = '';
            if($product->service_icon){
                $serviceIcon = $baseImagePath .'/'. $product->service_icon;
            }
            $imageUrls = $product->images->pluck('images')->toArray(); // Assuming 'images' holds the file path
           
            $imageUrls = array_map(function($imagePath) use ($baseImagePath) {
                return $baseImagePath .'/'. $imagePath;
            }, $imageUrls);

            $imageUrls = implode('; ', $imageUrls);

            fputcsv($handle, [
                $product->product_code,
                $product->category_id,
                $product->product_name,
                $product->manufacture_name,
                $product->supplier,
                $product->quantity,
                $product->vehicle_category_id,
                $product->description,
                $product->cost_price,
                $product->item_number,
                $imageUrls,
                $product->brand_id,
                $product->model_id,
                $product->varient_model_id,
                $product->type_id,
                $product->is_oem,
                $product->is_service,
                $serviceIcon,
                $product->short_description,
                $product->used_part,
                $product->access_series,
                $product->year
            ]);
        }

        fclose($handle);
        exit;
    }

}

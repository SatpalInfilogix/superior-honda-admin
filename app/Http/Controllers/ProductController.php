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
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            'product_code'      => 'required|unique:products',
            'category_id'       => 'required',
            'vehicle_category_id' => 'required',
            'product_name'      => 'required',
            'manufacture_name'  => 'required'
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
            'access_series'     => $request->access_series ?? 0,
            'description'       => $request->description,
            'cost_price'        => $request->cost_price,
            'item_number'       => $request->item_number,
            'created_by'        => Auth::id()
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
        $product = Product::with('images')->where('id', $product->id)->first();

        return view('products.edit', compact('product', 'categories', 'brands', 'vehicleModels', 'vehicleTypes','modelVariants', 'vehicleCategories'));

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
                Rule::unique('products', 'product_code')->ignore($product->id)
            ],
            'category_id' => 'required',
            'vehicle_category_id' => 'required',
            'product_name' => 'required',
            'manufacture_name' => 'required'
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
            'access_series'     => $request->access_series ?? 0,
            'description'       => $request->description,
            'cost_price'        => $request->cost_price,
            'item_number'       => $request->item_number,
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
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator);
        }

        $file = $request->file('file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));
        unset($data[0]);
        $header = [
            'product_code', 'category_id', 'product_name', 'manufacture_name', 'supplier', 'quantity', 'vehicle_category_id', 'description', 'cost_price', 'item_number'
        ];

        $errors = [];
        foreach ($data as $key => $row) {
            $row = array_combine($header, $row);
            $validator = Validator::make($row, [
                'product_code' => 'required|unique:products,product_code',
                'category_id'  => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (!ProductCategory::where('id', $value)->exists()) {
                            $fail('The selected category id '. $value .' is invalid for row.');
                        }
                    }
                ],
                'product_name'       => 'required',
                'manufacture_name'   => 'required',
                'vehicle_category_id'  => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (!VehicleCategory::where('id', $value)->exists()) {
                            $fail('The selected vehicle category id '. $value .' is invalid.');
                        }
                    }
                ]
            ]);

            if ($validator->fails()) {
                $errors[$key] = $validator->errors()->all();
                continue;
            }

            Product::create([
                'product_code'         => $row['product_code'],
                'category_id'          => $row['category_id'],
                'product_name'         => $row['product_name'],
                'manufacture_name'     => $row['manufacture_name'],
                'supplier'             => $row['supplier'],
                'quantity'             => $row['quantity'],
                'vehicle_category_id'  => $row['vehicle_category_id'],
                'description'          => $row['description'],
                'cost_price'           => $row['cost_price'],
                'item_number'          => $row['item_number'],
            ]);
        }

        if (!empty($errors)) {
            return redirect()->route('products.index')->with('error', $errors);
        }

        return redirect()->route('products.index')->with('success', 'CSV file imported successfully.');
    }
}

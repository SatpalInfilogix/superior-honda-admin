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

        $categories = ProductCategory::all();

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

        $product = Product::create([
            'product_name'      => $request->product_name,
            'category_id'       =>$request->category_id,
            'brand_id'          =>$request->brand_name,
            'model_id'          => $request->model_name,
            'varient_model_id'  =>$request->model_variant_name,
            'type_id'           => $request->vehicle_type,
            'manufacture_name'  => $request->manufacture_name,
            'supplier'          => $request->supplier,
            'quantity'          => $request->quantity,
            'hsn_no'            => $request->hsn_no,
            'is_oem'            => $request->oem ?? 0,
            'is_service'        => $request->is_service ?? 0
        ]);

        $images = $request->images;
        if ($images) {
            $files = [];
            if($request->hasfile('images'))
            {
                foreach($request->file('images') as $file)
                {
                    $filename = time().'.'.$file->getClientOriginalExtension();
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
        $brands = VehicleBrand::all();
        $vehicleModels = VehicleModel::all();
        $vehicleTypes = VehicleType::all();
        $modelVariants = VehicleModelVariant::all();
        $product = Product::with('images')->where('id', $product->id)->first();

        return view('products.edit', compact('product', 'categories', 'brands', 'vehicleModels', 'vehicleTypes','modelVariants'));

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
            'varient_model_id'=>$request->model_variant_name,
            'type_id'       => $request->vehicle_type,
            'manufacture_name' => $request->manufacture_name,
            'supplier'      => $request->supplier,
            'quantity'      => $request->quantity,
            'hsn_no'        => $request->hsn_no,
            'is_oem'        => $request->oem ?? 0,
            'is_service'    => $request->is_service ?? 0
        ]);

        if ($request->hasFile('images')) {
            if (count($request->images) > 0) {
                foreach ($request->file('images') as $file) {
                    $filename = time().'.'.$file->getClientOriginalExtension();
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
            'first_name', 'last_name', 'email', 'designation','additional_details','dob','role'
        ];

        $errors = [];
        $user = User::orderByDesc('emp_id')->first();
        if (!$user) {
            $empId =  'EMP0001';
        } else {
            $numericPart = (int)substr($user->emp_id, 3);
            $nextNumericPart = str_pad($numericPart + 1, 4, '0', STR_PAD_LEFT);
            $empId = 'EMP' . $nextNumericPart;
        }

        foreach ($data as $key => $row) {
            $row = array_combine($header, $row);

            $validator = Validator::make($row, [
                'first_name' => 'required',
                'last_name'  => 'required',
                'email'      => 'required|email|unique:users,email',
                'role'       => 'required',
            ],
            [
                'email.unique' => 'The email '. $row['email'] .' has already been taken.',
            ]);

            if ($validator->fails()) {
                $errors[$key] = $validator->errors()->all();
                continue;
            }

            User::create([
                'first_name'         => $row['first_name'],
                'last_name'          => $row['last_name'],
                'email'              => $row['email'],
                'designation'        => $row['designation'],
                'emp_id'             => $empId,
                'password'           => Hash::make(Str::random(10)),
                'additional_details' => $row['additional_details'],
                'date_of_birth'      => $row['dob'],
            ])->assignRole($row['role']);
        }

        if (!empty($errors)) {
            return redirect()->route('users.index')->with('error', $errors);
        }

        return redirect()->route('users.index')->with('success', 'CSV file imported successfully.');
    }
}

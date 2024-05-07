<?php

namespace App\Http\Controllers;

use App\Models\VehicleModelVariant;
use App\Models\VehicleCategory;
use App\Models\VehicleModel;
use Illuminate\Http\Request;

class VehicleModelVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicleModelVariants = VehicleModelVariant::latest()->get();

        return view('vehicle-model-variants.index', compact('vehicleModelVariants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = VehicleCategory::all();

        return view('vehicle-model-variants.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id'  => 'required',
            'variant_name' => 'required',
            'fuel_type'    => 'required',
            'model_variant_image' => 'required'
        ]);

        if ($request->hasFile('model_variant_image'))
        {
            $file = $request->file('model_variant_image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/variant_image/'), $filename);
        }

        VehicleModelVariant::create([
            'category_id'   =>$request->category_id,
            'brand_id'      =>$request->brand_name,
            'model_id'      => $request->model_name,
            'type_id'       => $request->vehicle_type,
            'variant_name'  => $request->variant_name,
            'fuel_type'     => $request->fuel_type,
            'model_variant_image' => 'uploads/variant_image/'. $filename,
        ]);

        return redirect()->route('vehicle-model-variants.index')->with('success', 'Vehicle model Variant saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(VehicleModelVariant $vehicleModelVariant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VehicleModelVariant $vehicleModelVariant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VehicleModelVariant $vehicleModelVariant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleModelVariant $vehicleModelVariant)
    {
        //
    }

    public function getVehicleModel(Request $request)
    {
        $vehicleModels = VehicleModel::where('brand_id', $request->brand_id)->get();
        $options='<option value="">Select Model</option>';
        foreach($vehicleModels as $model)
        {
            $options .= '<option value="'.  $model->id .'">'. $model->model_name	 .'</option>';
        }

        return response()->json([
            'options' => $options
        ]);
    }
}

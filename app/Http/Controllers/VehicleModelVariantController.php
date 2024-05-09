<?php

namespace App\Http\Controllers;

use App\Models\VehicleModelVariant;
use App\Models\VehicleCategory;
use App\Models\VehicleModel;
use App\Models\VehicleBrand;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use File;

class VehicleModelVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Gate::allows('view vehicle configuration')) {
            abort(403);
        }

        $vehicleModelVariants = VehicleModelVariant::latest()->get();
        return view('vehicle-model-variants.index', compact('vehicleModelVariants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Gate::allows('create vehicle configuration')) {
            abort(403);
        }

        $categories = VehicleCategory::all();
        return view('vehicle-model-variants.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Gate::allows('create vehicle configuration')) {
            abort(403);
        }

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
        if(!Gate::allows('edit vehicle configuration')) {
            abort(403);
        }

        $categories = VehicleCategory::all();
        $brands = VehicleBrand::all();
        $vehicleModels = VehicleModel::all();
        $vehicleTypes = VehicleType::all();

        return view('vehicle-model-variants.edit', compact('vehicleModelVariant', 'categories', 'brands', 'vehicleModels', 'vehicleTypes'));
    }   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VehicleModelVariant $vehicleModelVariant)
    {
        $request->validate([
            'category_id'  => 'required',
            'variant_name' => 'required',
            'fuel_type'    => 'required',
        ]);

        $oldImage = NULL;
        $vehicleModelVariant = VehicleModelVariant::findOrFail($vehicleModelVariant->id)->first();
        if($vehicleModelVariant != '') {
            $oldImage = $vehicleModelVariant->model_variant_image;
        }

        if ($request->hasFile('model_variant_image'))
        {
            $file = $request->file('model_variant_image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/variant_image/'), $filename);

            $image_path = public_path($oldImage);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        $vehicleModelVariant->update([
            'category_id'   =>$request->category_id,
            'brand_id'      =>$request->brand_name,
            'model_id'      => $request->model_name,
            'type_id'       => $request->vehicle_type,
            'variant_name'  => $request->variant_name,
            'fuel_type'     => $request->fuel_type,
            'model_variant_image' => isset($filename) ? 'uploads/variant_image/'. $filename : $oldImage,
        ]);

        return redirect()->route('vehicle-model-variants.index')->with('success', 'Vehicle model Variant updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleModelVariant $vehicleModelVariant)
    {
        VehicleModelVariant::where('id', $vehicleModelVariant->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vehicle model variant deleted successfully.'
        ]);
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

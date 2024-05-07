<?php

namespace App\Http\Controllers;

use App\Models\VehicleModel;
use App\Models\VehicleCategory;
use App\Models\VehicleBrand;
use Illuminate\Http\Request;
use File;

class VehicleModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicleModels = VehicleModel::latest()->get();

        return view('vehicle-models.index', compact('vehicleModels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = VehicleCategory::all();
        
        return view('vehicle-models.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'model_name'  => 'required',
            'model_image' => 'required'
        ]);

        if ($request->hasFile('model_image'))
        {
            $file = $request->file('model_image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/model_image/'), $filename);
        }

        VehicleModel::create([
            'category_id'   =>$request->category_id,
            'brand_id'      =>$request->brand_name,
            'model_name'    => $request->model_name,
            'model_image'   => 'uploads/model_image/'. $filename,
        ]);

        return redirect()->route('vehicle-models.index')->with('success', 'Vehicle model saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(VehicleModel $vehicleModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VehicleModel $vehicleModel)
    {
        $categories = VehicleCategory::all();
        $brands = VehicleBrand::all();

        return view('vehicle-models.edit', compact('vehicleModel', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VehicleModel $vehicleModel)
    {
        $request->validate([
            'category_id' => 'required',
            'model_name'  => 'required',
        ]);

        $oldImage = NULL;
        $vehicleModel = VehicleModel::findOrFail($vehicleModel->id)->first();
        if($vehicleModel != '') {
            $oldImage = $vehicleModel->model_image;
        }

        if ($request->hasFile('model_image'))
        {
           $file = $request->file('model_image');
           $filename = time().'.'.$file->getClientOriginalExtension();
           $file->move(public_path('uploads/model_image/'), $filename);

           $image_path = public_path($oldImage);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        $vehicleModel->update([
            'category_id' => $request->category_id,
            'brand_id'    => $request->brand_name,
            'model_name'  => $request->model_name,
            'model_image' => isset($filename) ? 'uploads/model_image/'. $filename : $oldImage,
        ]);

        return redirect()->route('vehicle-models.index')->with('success', 'Vehicle model updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleModel $vehicleModel)
    {
        VehicleModel::where('id', $vehicleModel->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vehicle model deleted successfully.'
        ]);
    }

    public function getVehicleBrand(Request $request)
    {
        $vehicleBrands = VehicleBrand::where('category_id', $request->category_id)->get();
        $options='<option value="">Select Brand </option>';
        foreach($vehicleBrands as $brand)
        {
            $options .= '<option value="'.  $brand->id .'">'. $brand->brand_name	 .'</option>';
        }

        return response()->json([
            'length' => count($vehicleBrands),
            'options' => $options
        ]);
    }
}

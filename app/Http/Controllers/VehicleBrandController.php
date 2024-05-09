<?php

namespace App\Http\Controllers;

use App\Models\VehicleBrand;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use File;

class VehicleBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Gate::allows('view vehicle configuration')) {
            abort(403);
        }

        $vehicleBrands = VehicleBrand::with('category')->latest()->get();
        return view('vehicle-brands.index', compact('vehicleBrands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Gate::allows('create vehicle configuration')) {
            abort(403);
        }

        $vehicleCategories = VehicleCategory::all();
        return view('vehicle-brands.create', compact('vehicleCategories'));
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
            'category_id' => 'required',
            'brand_name'  => 'required',
            'brand_logo'  => 'required'
        ]);

        if ($request->hasFile('brand_logo'))
        {
            $file = $request->file('brand_logo');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/brands/'), $filename);
        }

        VehicleBrand::create([
            'category_id' => $request->category_id,
            'brand_name'  => $request->brand_name,
            'brand_logo' => 'uploads/brands/'. $filename,
        ]);
        
        return redirect()->route('vehicle-brands.index')->with('success', 'Vehicle brand saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(VehicleBrand $vehicleBrand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VehicleBrand $vehicleBrand)
    {
        if(!Gate::allows('edit vehicle configuration')) {
            abort(403);
        }

        $vehicleCategories = VehicleCategory::all();
        return view('vehicle-brands.edit', compact('vehicleBrand', 'vehicleCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VehicleBrand $vehicleBrand)
    {
        if(!Gate::allows('edit vehicle configuration')) {
            abort(403);
        }

        $request->validate([
            'category_id' => 'required',
            'brand_name'  => 'required',
        ]);

        $brandLogo = VehicleBrand::where('id', $vehicleBrand->id)->first();
        $oldBrandLogo = NULL;
        if($brandLogo != '') {
            $oldBrandLogo = $brandLogo->brand_logo;
        }

        if ($request->hasFile('brand_logo'))
        {
            $file = $request->file('brand_logo');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/brands/'), $filename);

            $image_path = public_path($oldBrandLogo);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        VehicleBrand::where('id', $vehicleBrand->id)->update([
            'category_id' => $request->category_id,
            'brand_name'  => $request->brand_name,
            'brand_logo' => isset($filename) ? 'uploads/brands/'. $filename : $oldBrandLogo,
        ]);

        return redirect()->route('vehicle-brands.index')->with('success', 'Vehicle brand updated successfully'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleBrand $vehicleBrand)
    {
        if(!Gate::allows('delete vehicle configuration')) {
            abort(403);
        }
        
        VehicleBrand::where('id', $vehicleBrand->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vehicle brand deleted successfully.'
        ]);
    }
}

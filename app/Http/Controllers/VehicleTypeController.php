<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicle_types = VehicleType::latest()->get();

        return view('vehicle-types.index', compact('vehicle_types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = VehicleCategory::all();
        return view('vehicle-types.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[ 
            'category_id' => 'required',
            'vehicle_type' => 'required|unique:vehicle_types,vehicle_type',
        ]);
    
        VehicleType::create([
            'category_id' => $request->category_id,
            'vehicle_type' => $request->vehicle_type
        ]);

        return redirect()->route('vehicle-categories.index')->with('success', 'Vehicle type saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(VehicleType $vehicleType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VehicleType $vehicleType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VehicleType $vehicleType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleType $vehicleType)
    {
        VehicleType::where('id', $vehicleType->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vehicle type deleted successfully.'
        ]);
    }
}

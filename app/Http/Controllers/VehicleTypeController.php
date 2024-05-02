<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[ 
            'add_vehicle_type' => 'required|unique:vehicle_types,vehicle_type',
        ]);
    
        if($validation->fails()){
            return response()->json([
                'success' => false,
                'message'  => $validation->errors()->first()
            ]);
        }

        VehicleType::create([
            'vehicle_type' => $request->add_vehicle_type
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vehicle type added successfully.'
        ]);
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

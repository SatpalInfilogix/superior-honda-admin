<?php

namespace App\Http\Controllers;

use App\Models\CarType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carTypes = CarType::latest()->get();

        return view('vehicle-types.index', compact('carTypes'));
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
            'add_vehicle_type' => 'required|unique:car_types,car_type',
        ]);
    
        if($validation->fails()){
            return response()->json([
                'success' => false,
                'message'  => $validation->errors()->first()
            ]);
        }

        CarType::create([
            'car_type' => $request->add_vehicle_type
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vehicle type created successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(CarType $carType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CarType $carType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarType $carType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarType $carType)
    {
        //
    }
}

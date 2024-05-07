<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class VehicleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Gate::allows('view vehicle configuration')) {
            abort(403);
        }

        $vehicle_types = VehicleType::with('category')->latest()->get();
        return view('vehicle-types.index', compact('vehicle_types'));
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
        return view('vehicle-types.create', compact('categories'));
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
            'vehicle_type' => [
                'required',
                Rule::unique('vehicle_types')->where(function ($query) use ($request) {
                    return $query->where('category_id', $request->category_id);
                }),
            ],
        ]);

            VehicleType::create([
                'category_id' => $request->category_id,
                'vehicle_type' => $request->vehicle_type
            ]);

            return redirect()->route('vehicle-types.index')->with('success', 'Vehicle type saved successfully');
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
        if(!Gate::allows('edit vehicle configuration')) {
            abort(403);
        }

        $categories = VehicleCategory::all();
        $vehicleType = VehicleType::with('category')->where('id', $vehicleType->id)->first();
        return view('vehicle-types.edit', compact('vehicleType', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VehicleType $vehicleType)
    {
        if(!Gate::allows('edit vehicle configuration')) {
            abort(403);
        }

        $request->validate([
            'category_id' => 'required',
            'vehicle_type' => [
                'required',
                Rule::unique('vehicle_types')->where(function ($query) use ($request) {
                    return $query->where('category_id', $request->category_id);
                })->ignore($vehicleType->id),
            ],
        ]);

        $vehicleType = VehicleType::where('id', $vehicleType->id)->update([
            'category_id' => $request->category_id,
            'vehicle_type' => $request->vehicle_type
        ]);

        return redirect()->route('vehicle-types.index')->with('success', 'Vehicle type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleType $vehicleType)
    {
        if(!Gate::allows('delete vehicle configuration')) {
            abort(403);
        }

        VehicleType::where('id', $vehicleType->id)->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Vehicle type deleted successfully.'
        ]);
    }
}

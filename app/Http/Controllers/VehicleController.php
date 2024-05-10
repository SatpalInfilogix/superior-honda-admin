<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\User;
use App\Models\VehicleCategory;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use App\Models\VehicleModel;
use App\Models\VehicleBrand;
use App\Models\VehicleType;
use App\Models\VehicleModelVariant;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if(!Gate::allows('view vehicles')) {
        //     abort(403);
        // }

        $vehicles = Vehicle::with('customer')->latest()->get();

        return view('vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // if(!Gate::allows('create vehicles')) {
        //     abort(403);
        // }

        $customerRole = Role::where('name', 'Customer')->first();

        $customers = User::whereHas('roles', function ($query) use ($customerRole) {
            $query->where('role_id', $customerRole->id);
        })->latest()->get();

        $categories = VehicleCategory::all();

        return view('vehicles.create', compact('customers' ,'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // if(!Gate::allows('create vehicles')) {
        //     abort(403);
        // }

        $request->validate([
            'customer_id'  => 'required',
            'category_id'  => 'required',
            'vehicle_no'   => 'required',
            'year'         => 'required'
        ]);

        Vehicle::create([
            'cus_id'            => $request->customer_id,
            'category_id'       => $request->category_id,
            'brand_id'          => $request->brand_name,
            'model_id'          => $request->model_name,
            'varient_model_id'  => $request->model_variant_name,
            'type_id'           => $request->vehicle_type,
            'vehicle_no'        => $request->vehicle_no,
            'year'              => $request->year,
            'color'             => $request->color,
            'chasis_no'         => $request->chasis_no,
            'engine_no'         => $request->engine_no,
            'additional_details' => $request->additional_detail
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        $customerRole = Role::where('name', 'Customer')->first();

        $customers = User::whereHas('roles', function ($query) use ($customerRole) {
            $query->where('role_id', $customerRole->id);
        })->latest()->get();

        $categories = VehicleCategory::all();
        $brands = VehicleBrand::all();
        $vehicleModels = VehicleModel::all();
        $vehicleTypes = VehicleType::all();
        $modelVariants = VehicleModelVariant::all();

        return view('vehicles.edit', compact('vehicle', 'categories', 'brands', 'vehicleModels', 'vehicleTypes','modelVariants', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'customer_id'  => 'required',
            'category_id'  => 'required',
            'vehicle_no'   => 'required',
            'year'         => 'required'
        ]);

        $vehicle = Vehicle::where('id', $vehicle->id)->first();

        $vehicle->update([
            'cus_id'            => $request->customer_id,
            'category_id'       => $request->category_id,
            'brand_id'          => $request->brand_name,
            'model_id'          => $request->model_name,
            'varient_model_id'  => $request->model_variant_name,
            'type_id'           => $request->vehicle_type,
            'vehicle_no'        => $request->vehicle_no,
            'year'              => $request->year,
            'color'             => $request->color,
            'chasis_no'         => $request->chasis_no,
            'engine_no'         => $request->engine_no,
            'additional_details' => $request->additional_detail
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully');
  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $Vehicle)
    {
        Vehicle::where('id', $Vehicle->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vehicle deleted successfully.'
        ]);
    }
}

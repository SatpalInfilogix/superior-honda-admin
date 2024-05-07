<?php

namespace App\Http\Controllers;

use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VehicleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Gate::allows('view vehicle configuration')) {
            abort(403);
        }

        $categories = VehicleCategory::all();
        return view('vehicle-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Gate::allows('create vehicle configuration')) {
            abort(403);
        }

        return view('vehicle-categories.create');
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
            'name' => 'required|unique:vehicle_categories|max:25'
        ]);

        $category = new VehicleCategory();
        $category->name = $request->name;
        $category->save();
        
        return redirect()->route('vehicle-categories.index')->with('success', 'Vehicle category saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(VehicleCategory $vehicleCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VehicleCategory $vehicle_category)
    {
        if(!Gate::allows('edit vehicle configuration')) {
            abort(403);
        }

        return view('vehicle-categories.edit', compact('vehicle_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VehicleCategory $vehicle_category)
    {
        if(!Gate::allows('edit vehicle configuration')) {
            abort(403);
        }

        $category = VehicleCategory::find($vehicle_category->id);
        $category->name = $request->name;
        $category->save();

        return redirect()->route('vehicle-categories.index')->with('success', 'Vehicle category update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleCategory $vehicle_category)
    {
        if(!Gate::allows('delete vehicle configuration')) {
            abort(403);
        }

        VehicleCategory::where('id', $vehicle_category->id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Vehicle category deleted successfully.'
        ]);
    }
}

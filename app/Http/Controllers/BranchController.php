<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\BranchLocations;
use App\Imports\BranchImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;


class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! Gate::allows('view branch')) {
            abort(403);
        }

        $branches = Branch::with('branch_locations.location')
                        ->whereHas('branch_locations.location', function ($query) {
                            $query->whereNull('deleted_at');
                        })->latest()->get();
                        
        return view('branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('create branch')) {
            abort(403);
        }

        $adminRoles = Role::whereIn('name', ['Super Admin', 'Admin'])->get();

        $locations = Location::where('deleted_at', NULL)->where('disable_location', '0')->get();
        
        $users = User::whereHas('roles', function ($query) use ($adminRoles) {
                    $query->whereIn('role_id', $adminRoles->pluck('id'));
                })->latest()->get();

        return view('branches.create', compact('users', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! Gate::allows('create branch')) {
            abort(403);
        }

        $request->validate([
            'name'    => 'required',
            'address' => 'required',
            'pincode' => 'required',
            'location_id'    => 'required',
        ]);

        $branch = Branch::orderByDesc('unique_code')->first();
        if (!$branch) {
            $uniqueCode =  'BR0001';
        } else {
            $numericPart = (int)substr($branch->unique_code, 3);
            $nextNumericPart = str_pad($numericPart + 1, 4, '0', STR_PAD_LEFT);
            $uniqueCode = 'BR' . $nextNumericPart;
        }

        if (is_array($request->week_status)) {
            $weekStatus = implode(',', $request->week_status);
        } else {
            $weekStatus = $request->week_status;
        }

        $branch = Branch::create([
            'unique_code'   => $uniqueCode,
            'name'          => $request->name,
            'start_time'    => $request->start_time,
            'end_time'      => $request->end_time,
            'branch_head'   => $request->branch_head,
            'address'       => $request->address,
            'pincode'       => $request->pincode,
            'status'        => $request->status,
            'week_status'   => $weekStatus
        ]);

        $locations = $request->location_id;

        foreach($locations as $location)
        {
            $branch_location = [];
            $branch_location['branch_id'] = $branch->id;
            $branch_location['location_id'] = $location;
            
            BranchLocations::create($branch_location);
        }

        return redirect()->route('branches.index')->with('success', 'Branch saved successfully'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        if (! Gate::allows('edit branch')) {
            abort(403);
        }

        $adminRole = Role::where('name', 'Admin')->first();

        $locations = Location::where('deleted_at', NULL)->where('disable_location', '0')->get();

        $users = User::whereHas('roles', function ($query) use ($adminRole) {
            $query->where('role_id', $adminRole->id);
        })->latest()->get();

        $branch = Branch::with('branch_locations.location')->where('id', $branch->id)->first();
        $branch['week_status'] = explode(',' ,$branch->week_status);

        return view('branches.edit', compact('branch', 'users', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        if (! Gate::allows('edit branch')) {
            abort(403);
        }

        $request->validate([
            'name'    => 'required',
            'address' => 'required',
            'pincode' => 'required',
            'location_id'    => 'required',
        ]);

        if (is_array($request->week_status)) {
            $weekStatus = implode(',', $request->week_status);
        } else {
            $weekStatus = $request->week_status;
        }

        $branch = Branch::where('id', $branch->id)->first();
        $branch->update([
            'name'            => $request->name,
            'start_time'      => $request->start_time,
            'end_time'        => $request->end_time,
            'branch_head'     => $request->branch_head,
            'address'         => $request->address,
            'pincode'         => $request->pincode,
            'status'          => $request->status,
            'week_status'     => $weekStatus
        ]);
        
        // old parent branch locations
        $old_branch_locations = BranchLocations::where('branch_id', $branch->id)->get()->pluck('location_id')->toArray();

        // new parent branch locations
        $new_branch_locations = $request->location_id;

        // branch locations to add (new but not in old)
        $branch_locations_to_add = array_diff($new_branch_locations, $old_branch_locations);

        // branch locations to delete (old but not in new)
        $branch_locations_to_delete = array_diff($old_branch_locations, $new_branch_locations);

        // Add new branch locations
        foreach ($branch_locations_to_add as $branch_location_to_add) {
            BranchLocations::create([
                'branch_id' => $branch->id,
                'location_id' => $branch_location_to_add
            ]);
        }

        // Delete removed branch locations
        foreach ($branch_locations_to_delete as $branch_location_to_delete) {
            BranchLocations::where('branch_id', $branch->id)
                ->where('location_id', $branch_location_to_delete)
                ->delete();
        }

        return redirect()->route('branches.index')->with('success', 'Branch updated successfully'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        if (! Gate::allows('delete branch')) {
            abort(403);
        }
        
        Branch::where('id', $branch->id)->delete();

        if(BranchLocations::where('branch_id', $branch->id)->exists())
        {
            $branch_locations = BranchLocations::where('branch_id', $branch->id)->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Branch deleted successfully.'
        ]);
    }

    public function disableBranch(Request $request)
    {
        $branch = Branch::where('id', $request->id)->first();
        $status = 1;
        $message = 'Branch disabled successfully.';
        if($request->disable_branch == 'disabled'){
            $status = '0';
            $message = 'Branch enabled successfully.';
        }else{
            $status = '1';
            $message = 'Branch disabled successfully.';
        }

        $branch->update([
          'disable_branch' => $status  
        ]);

        return response()->json([
                'success' => true,
                'message' => $message
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx',
        ]);

        $import = new BranchImport;
        Excel::import($import, $request->file('file'));

        Session::flash('import_errors', $import->getErrors());

        return redirect()->route('branches.index')->with('success', 'Branches imported successfully.');
    }
}

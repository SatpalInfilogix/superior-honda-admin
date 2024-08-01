<?php

namespace App\Http\Controllers;

use App\Models\Bay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Branch;

class BayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! Gate::allows('view bay')) {
            abort(403);
        }

        $bays = Bay::latest()->get();
        return view('bay.index', compact('bays'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('create bay')) {
            abort(403);
        }

        $adminRole = Role::where('name', 'Admin')->first();

        $users = User::whereHas('roles', function ($query) use ($adminRole) {
            $query->where('role_id', $adminRole->id);
        })->latest()->get();
        $branches = Branch::where('disable_branch', 0)->get();
        return view('bay.create')->with([
        								 'users' => $users,
        								 'branchesData' => $branches
        								]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! Gate::allows('create bay')) {
            abort(403);
        }

        $request->validate([
            'name'    => 'required',
        ]);
    
        Bay::create([
            'name'          => $request->name,
            'branch_id'     => $request->branch_head
        ]);

        return redirect()->route('bay.index')->with('success', 'Bay saved successfully'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Bay $bay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($bay)
    {
        if (! Gate::allows('edit bay')) {
            abort(403);
        }

        $adminRole = Role::where('name', 'Admin')->first();
        $users = User::whereHas('roles', function ($query) use ($adminRole) {
            $query->where('role_id', $adminRole->id);
        })->latest()->get();

        $bay = Bay::where('id', $bay)->first();
        $branchdata = Branch::where('disable_branch', 0)->get();

        return view('bay.edit', compact('bay', 'users', 'branchdata'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bay $bay)
    {
        if (! Gate::allows('edit bay')) {
            abort(403);
        }

        $request->validate([
            'name'    => 'required',
            'branch_head' => 'required',
        ]);

        Bay::where('id', $bay->id)->update([
            'name'          => $request->name,
            'branch_id'     => $request->branch_head
        ]);

        return redirect()->route('bay.index')->with('success', 'bay updated successfully'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bay $bay)
    {
        if (! Gate::allows('delete bay')) {
            abort(403);
        }

        Bay::where('id', $bay->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Bay deleted successfully.'
        ]);
    }

    public function disableBay(Request $request)
    {
        $bay = Bay::where('id', $request->id)->first();
        $status = 1;
        $message = 'Bay enabled successfully.';
        if($bay->status == 1){
            $message = 'Bay disabled successfully.';
            $status = 0;
        }

        $bay->update([
          'status' => $status  
        ]);

        return response()->json([
                'success' => true,
                'message' => $message
        ]);
    }
}


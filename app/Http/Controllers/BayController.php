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

        $branches = Bay::latest()->get();
        return view('bay.index', compact('branches'));
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
        $branches = Branch::get();
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
        if (! Gate::allows('create branch')) {
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
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($branch)
    {
        if (! Gate::allows('edit branch')) {
            abort(403);
        }
        // dd($branch);

        $adminRole = Role::where('name', 'Admin')->first();

        $users = User::whereHas('roles', function ($query) use ($adminRole) {
            $query->where('role_id', $adminRole->id);
        })->latest()->get();

        $branch = Bay::where('id', $branch)->first();
        // dd($branch->id);
        $branchdata = Branch::get();
        return view('bay.edit', compact('branch', 'users','branchdata'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bay $branch)
    {
        if (! Gate::allows('edit branch')) {
            abort(403);
        }

        $request->validate([
            'name'    => 'required',
            'address' => 'required',
            'pincode' => 'required'
        ]);

        Bay::where('id', $branch->id)->update([
            'name'          => $request->name,
            'branch_id'     => $request->branch_head
        ]);

        return redirect()->route('bay.index')->with('success', 'bay updated successfully'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bay $branch)
    {
        if (! Gate::allows('delete branch')) {
            abort(403);
        }

        Bay::where('id', $branch->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Bay deleted successfully.'
        ]);
    }
}


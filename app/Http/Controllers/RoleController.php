<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Gate::allows('view roles & permissions')) {
            abort(403);
        }

        $roles = Role::get();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles'
        ]);

        Role::create([
            'name' => $request->name
        ]);
        
        return redirect()->route('roles.index')->with('success', 'Role saved successfully'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles'
        ]);

        Role::where('id', $role->id)->update([
            'name' => $request->name
        ]);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        Role::where('id', $role->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully.'
        ]);
    }
}

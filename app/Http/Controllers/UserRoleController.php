<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRole;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = UserRole::latest()->get();

        return view('user-roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user-roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|unique:user_roles|max:25'
        ]);

        UserRole::create([
            'role' => $request->role
        ]);
        
        return redirect()->route('user-roles.index')->with('success', 'Role saved successfully'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserRole $user_role)
    {
        return view('user-roles.edit', compact('user_role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserRole $user_role)
    {
        $role = UserRole::find($user_role->id)->update([
            'role' => $request->role
        ]);

        return redirect()->route('user-roles.index')->with('success', 'Role update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserRole $user_role)
    {
        UserRole::where('id', $user_role->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully.'
        ]);
    }
}

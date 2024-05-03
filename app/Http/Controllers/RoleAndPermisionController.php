<?php

namespace App\Http\Controllers;

use App\Models\RoleAndPermission;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class RoleAndPermisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->orderBy('id', 'ASC')
            ->where('id', '!=', 1)
            ->where('name', '!=', 'Customer')
            ->get();

        $modules = ['Users', 'Customers', 'Cars', 'Branches', 'Inquiries', 'Inspection', 'Jobs', 'Invoices', 'Products', 'Services', 'Towing Request', 'Orders', 'Copons', 'Payments', 'Email Templates'];

        return view('roles-and-permissions.index', compact('roles', 'modules'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RoleAndPermission $roleAndPermission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoleAndPermission $roleAndPermission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoleAndPermission $roleAndPermission)
    {
        $role = Role::findOrFail($request->role_id);
        $permission_name = $request->permission_name;

        $permission = Permission::where('name', $permission_name)->firstOrFail();

        if ($role->permissions->contains($permission)) {
            $role->permissions()->detach($permission);
            $message = 'Permission removed successfully';
        } else {
            $role->permissions()->attach($permission);
            $message = 'Permission assigned successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleAndPermission $roleAndPermission)
    {
        //
    }
}

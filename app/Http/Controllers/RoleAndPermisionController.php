<?php

namespace App\Http\Controllers;

use App\Models\RoleAndPermission;
use Illuminate\Http\Request;

class RoleAndPermisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('roles-and-permissions.index');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleAndPermission $roleAndPermission)
    {
        //
    }
}

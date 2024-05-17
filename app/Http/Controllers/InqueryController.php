<?php

namespace App\Http\Controllers;

use App\Models\Inquery;
use Illuminate\Http\Request;

class InqueryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('inquiries.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inquiries.create');
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
    public function show(Inquery $inquery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inquery $inquery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inquery $inquery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inquery $inquery)
    {
        //
    }
}

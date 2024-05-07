<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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

        $branches = Branch::latest()->get();
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

        return view('branches.create');
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
            'pincode' => 'required'
        ]);

        $branch = Branch::orderByDesc('unique_code')->first();
        if (!$branch) {
            $uniqueCode =  'BR0001';
        } else {
            $numericPart = (int)substr($branch->unique_code, 3);
            $nextNumericPart = str_pad($numericPart + 1, 4, '0', STR_PAD_LEFT);
            $uniqueCode = 'BR' . $nextNumericPart;
        }
    
        Branch::create([
            'name'          => $request->name,
            'timing'        => $request->timing,
            'unique_code'   => $uniqueCode,
            'operating_hours' => $request->operating_hours,
            'branch_head'   => $request->branch_head,
            'address'       => $request->address,
            'pincode'       => $request->pincode,
            'status'        => $request->status,
        ]);

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

        $branch = Branch::where('id', $branch->id)->first();
        return view('branches.edit', compact('branch'));
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
            'pincode' => 'required'
        ]);

        Branch::where('id', $branch->id)->update([
            'name'            => $request->name,
            'timing'          => $request->timing,
            'operating_hours' => $request->operating_hours,
            'branch_head'     => $request->branch_head,
            'address'         => $request->address,
            'pincode'         => $request->pincode,
            'status'          => $request->status,
        ]);

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

        return response()->json([
            'success' => true,
            'message' => 'Branch deleted successfully.'
        ]);
    }
}

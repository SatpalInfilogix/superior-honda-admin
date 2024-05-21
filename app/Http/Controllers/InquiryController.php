<?php

namespace App\Http\Controllers;

use App\Models\inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inquiries = Inquiry::latest()->get();

        return view('inquiries.index', compact('inquiries'));
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
        $productConditions = NULL;

        if ($request->products != '') {
            foreach ($request->products as $key => $product) {
                $productConditions[] = [
                    'product' => $key,
                    'condition' => $product['condition']
                ];
            }
        }

        $request->validate([
            'name' => 'required',
        ]);

        Inquiry::create([
            'name'          => $request->name,
            'date'          => $request->date,
            'mileage'       => $request->mileage,
            'vehicle'       => $request->vehicle,
            'year'          => $request->year,
            'lic_no'        => $request->lic_no,
            'address'       => $request->address,
            'returning'     => $request->returning,
            'color'         => $request->color,
            'tel_digicel'   => $request->tel_digicel,
            'tel_lime'      => $request->tel_lime,
            'dob'           => $request->dob,
            'chassis'       => $request->chassis,
            'engine'        => $request->engine,
            'conditions'    => isset($productConditions) ? json_encode($productConditions) : NULL,
            'sign'          => $request->signature,
            'sign_date'     =>  $request->sign_date
        ]);

        return redirect()->route('inquiries.index')->with('success', 'Inquiry created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(inquiry $inquiry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(inquiry $inquiry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, inquiry $inquiry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(inquiry $inquiry)
    {
        $product = inquiry::where('id', $inquiry->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Inquiry deleted successfully.'
        ]);
    }
}

<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Inspection;
use App\Models\Job;
class InspectionController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inspections = Inspection::latest()->get();

        return view('inspection.index', compact('inspections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('inquiries.create');
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
    public function show(Inspection $inspection)
    {
        return view('inspection.view', compact('inspection'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inspection $inspection)
    {
        return view('inspection.edit', compact('inspection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inspection $inspection)
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

        $inspection = Inspection::where('id', $inspection->id)->first();
        $inspection->update([
            'name'          => $request->name,
            'date'          => $request->date,
            'mileage'       => $request->mileage,
            'vehicle'       => $request->vehicle,
            'year'          => $request->year,
            'licence_no'    => $request->licence_no,
            'address'       => $request->address,
            'returning'     => $request->returning,
            'color'         => $request->color,
            'tel_digicel'   => $request->tel_digicel,
            'tel_lime'      => $request->tel_lime,
            'dob'           => $request->dob,
            'chassis'       => $request->chassis,
            'engine'        => $request->engine,
            'conditions'    => isset($productConditions) ? json_encode($productConditions) : NULL,
            'sign'          => $inspection->sign,
            'sign_date'     => $request->sign_date,
            'notes'         => $request->notes
        ]);

        return redirect()->route('inspection.index')->with('success', 'Inspection updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inspection $inspection)
    {
        $product = Inspection::where('id', $inspection->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Inspection deleted successfully.'
        ]);
    }

    public function inqueryInfo(Request $request)
    {
        $licenseNo = $request->input('licenseNo');
        $inspections = '';
        if($licenseNo != '') {
            $inspections = Inspection::where('licence_no', 'like', '%' . $licenseNo . '%')->get();
        }
        $html = '';
        if(count($inspections) > 0) {
            foreach ($inspections as $key => $inspection) {
                $html .= '<tr>
                            <td>'.++$key.'</td>
                            <td>'.$inspection['name'].'</td>
                            <td>'.$inspection['date'].'</td>
                            <td>'.$inspection['licence_no'].'</td>
                            <td>'.$inspection['status'].'</td>
                            <td><a href="'. route('inspection.show', $inspection->id) .'" target="_blank" class="btn btn-primary waves-effect waves-light mr-2 primary-btn">
                                <i class="feather icon-eye m-0"></i>
                                </a>
                            </td>
                        </tr>';
            }
        }
        else {
            $html = '<tr>
                        <td class="text-center" colspan="10"> No record found! </td>
                    </tr>';
        }
        return response()->json([
            'success' => true,
            'html'   => $html
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $inspection = Inspection::find($id);
        if ($inspection) {
            if($inspection->status != 'Completed') {
                $inspection->status = $request->input('status');
                $inspection->save();

                if($request->status == 'Completed') {
                    $job = Job::create([
                        'inspection_id' => $id,
                        'name'          => $inspection->name,
                        'date'          => $inspection->date,
                        'mileage'       => $inspection->mileage,
                        'vehicle'       => $inspection->vehicle,
                        'year'          => $inspection->year,
                        'licence_no'    => $inspection->licence_no,
                        'address'       => $inspection->address,
                        'returning'     => $inspection->returning,
                        'color'         => $inspection->color,
                        'tel_digicel'   => $inspection->tel_digicel,
                        'tel_lime'      => $inspection->tel_lime,
                        'dob'           => $inspection->dob,
                        'chassis'       => $inspection->chassis,
                        'engine'        => $inspection->engine,
                        'conditions'    => $inspection->conditions,
                        'sign'          => $inspection->sign,
                        'sign_date'     => $inspection->sign_date,
                        'status'        => 'Pending',
                        'notes'         => $inspection->notes
                    ]);
                }
                return response()->json(['success' => true, 'message' => 'Inspection status change successfully.' ]);
            } else {
                return response()->json(['success' => true, 'message' => 'Inspection status already completed.' ]);
            }

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

}

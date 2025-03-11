<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Inspection;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inquiries = Inquiry::latest()->get();
        // echo "<pre>";
        // print_r($inquiries);
        // die;
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
       if($request->signature !=  ''){
            $base64_str = substr($request->signature, strpos($request->signature, ",")+1);
            $file = base64_decode($base64_str);
            $filename = time() . '.png';
            $directory = public_path() . '/uploads/inquiry-signature/';
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true); // Create directory if it doesn't exist
            }

            $path = $directory . $filename;
            $success = file_put_contents($path, $file);
        }

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
            'email'         => $request->email,
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
            'sign'          => 'uploads/inquiry-signature/'. $filename,
            'sign_date'     => $request->sign_date,
            'notes'         => $request->notes
        ]);

        return redirect()->route('inquiries.index')->with('success', 'Inquiry created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inquiry $inquiry)
    {
        return view('inquiries.view', compact('inquiry'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inquiry $inquiry)
    {
        return view('inquiries.edit', compact('inquiry'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inquiry $inquiry)
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

        $inquery = Inquiry::where('id', $inquiry->id)->first();

        if($inquiry->status != 'completed') {
            if($request->status == 'completed') {
                $inspection = Inspection::create([
                    'inquiry_id'    => $inquery->id,
                    'name'          => $inquiry->name,
                    'date'          => $inquiry->date,
                    'mileage'       => $inquiry->mileage,
                    'vehicle'       => $inquiry->vehicle,
                    'year'          => $inquiry->year,
                    'licence_no'    => $inquiry->licence_no,
                    'address'       => $inquiry->address,
                    'returning'     => $inquiry->returning,
                    'color'         => $inquiry->color,
                    'tel_digicel'   => $inquiry->tel_digicel,
                    'tel_lime'      => $inquiry->tel_lime,
                    'dob'           => $inquiry->dob,
                    'chassis'       => $inquiry->chassis,
                    'engine'        => $inquiry->engine,
                    'conditions'    => $inquiry->conditions,
                    'sign'          => $inquiry->sign,
                    'sign_date'     => $inquiry->sign_date,
                    'status'        => 'Pending',
                    'notes'         => $inquiry->notes
                ]);
            }
        }
        $inquery->update([
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
            'sign'          => $inquiry->sign,
            'sign_date'     => $request->sign_date,
            'notes'         => $request->notes,
            'status'        => $request->status
        ]);

        return redirect()->route('inquiries.index')->with('success', 'Inquiry updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inquiry $inquiry)
    {
        $product = Inquiry::where('id', $inquiry->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Inquiry deleted successfully.'
        ]);
    }

    public function inqueryInfo(Request $request)
    {
        $licenseNo = $request->input('licenseNo');
        $inquiries = [];
        if ($licenseNo != '') {
            $inquiries = Inquiry::where('licence_no', 'like', '%' . $licenseNo . '%')->get();
        }
        $html = '';
        if (count($inquiries) > 0) {
            foreach ($inquiries as $key => $inquiry) {
                $html .= '<tr>
                            <td>' . ++$key . '</td>
                            <td>' . $inquiry['name'] . '</td>
                            <td>' . $inquiry['date'] . '</td>
                            <td>' . $inquiry['licence_no'] . '</td>
                            <td class="btn-group-sm">
                                <a href="' . route('inquiries.show', $inquiry->id) . '" target="_blank" class="btn btn-primary waves-effect waves-light mr-2 primary-btn">
                                    <i class="feather icon-eye m-0"></i>
                                </a>';

                if ($request->type != 'edit') {
                    $html .= '<a href="#" class="btn btn-primary waves-effect waves-light mr-2 primary-btn check-btn" data-id="' . $inquiry->id . '">
                                <i class="feather icon-check m-0"></i>
                            </a>';
                }

                $html .= '</td>
                        </tr>';
            }
        } else {
            $html = '<tr>
                        <td class="text-center" colspan="5"> No record found! </td>
                    </tr>';
        }
        return response()->json([
            'success' => true,
            'html'   => $html
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $inquiry = Inquiry::find($id);
        if ($inquiry) {
            if($inquiry->status != 'Completed') {
                $inquiry->status = $request->input('status');
                $inquiry->save();
                if($request->status == 'Completed') {
                    $inspection = Inspection::create([
                        'inquiry_id'    => $id,
                        'name'          => $inquiry->name,
                        'date'          => $inquiry->date,
                        'mileage'       => $inquiry->mileage,
                        'vehicle'       => $inquiry->vehicle,
                        'year'          => $inquiry->year,
                        'licence_no'    => $inquiry->licence_no,
                        'address'       => $inquiry->address,
                        'returning'     => $inquiry->returning,
                        'color'         => $inquiry->color,
                        'tel_digicel'   => $inquiry->tel_digicel,
                        'tel_lime'      => $inquiry->tel_lime,
                        'dob'           => $inquiry->dob,
                        'chassis'       => $inquiry->chassis,
                        'engine'        => $inquiry->engine,
                        'conditions'    => $inquiry->conditions,
                        'sign'          => $inquiry->sign,
                        'sign_date'     => $inquiry->sign_date,
                        'status'        => 'Pending',
                        'notes'         => $inquiry->notes
                    ]);
                }
                return response()->json(['success' => true, 'message' => 'Inquery status change successfully.' ]);
            } else {
                return response()->json(['success' => true, 'message' => 'Inquery status already completed.' ]);
            }
        }

        return response()->json(['success' => false], 404);
    }

    public function printInquiryList()
    {
        $records = Inquiry::all();

        return view('print.inquery-inspection-list', compact('records'));
    }

    public function printInquery($id)
    {
        $records = Inquiry::where('id', $id)->first();

        return view('print.inquery-inspection', compact('records'));
    }

    public function getInquiry($id)
    {
        $inquiry = Inquiry::find($id);

        if (!$inquiry) {
            return response()->json([
                'success' => false,
                'message' => 'Inquiry not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'inquiry' => $inquiry
        ]);
    }

}

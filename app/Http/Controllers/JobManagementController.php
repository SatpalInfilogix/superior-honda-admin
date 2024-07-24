<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Branch;
use App\Models\Bay;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class JobManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::latest()->get();

        return view('jobs.index', compact('jobs'));
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
    public function show(Job $job)
    {
        return view('jobs.view', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        $branches = Branch::latest()->get();
        $bays = Bay::latest()->get();
        $customerRole = Role::where('name', 'Technician')->first();
        $users = User::where('branch_id', $job->branch_id)->whereHas('roles', function ($query) use ($customerRole) {
            $query->where('role_id', $customerRole->id);
        })->latest()->get();

        
        return view('jobs.edit', compact('job', 'branches','bays', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
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

        $job = Job::where('id', $job->id)->first();
        $job->update([
            'branch_id'     => $request->branch_id,
            'bay_id'        => $request->bay_id,
            'user_id'       => $request->user_id,
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
            'sign'          => $job->sign,
            'sign_date'     => $request->sign_date,
            'notes'         => $request->notes,

        ]);

        return redirect()->route('jobs.index')->with('success', 'Job updated successfully.');
  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        $job = Job::where('id', $job->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Job deleted successfully.'
        ]);
    }

    public function jobInfo(Request $request)
    {
        $licenseNo = $request->input('licenseNo');
        $jobs = '';
        if($licenseNo != '') {
            $jobs = Job::where('licence_no', 'like', '%' . $licenseNo . '%')->get();
        }
        $html = '';
        if(count($jobs) > 0) {
            foreach ($jobs as $key => $jobs) {
                $html .= '<tr>
                            <td>'.++$key.'</td>
                            <td>'.$jobs['name'].'</td>
                            <td>'.$jobs['date'].'</td>
                            <td>'.$jobs['licence_no'].'</td>
                            <td>'.$jobs['status'].'</td>
                            <td><a href="'. route('jobs.show', $jobs->id) .'" target="_blank" class="btn btn-primary waves-effect waves-light mr-2 primary-btn">
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
        $job = Job::find($id);
        if ($job) {
            $job->status = $request->input('status');
            $job->save();
            return response()->json(['success' => true, 'message' => 'Job status change successfully.' ]);
        }
        return response()->json(['success' => false], 404);
    }

    public function getBay(Request $request) 
    {
        $customerRole = Role::where('name', 'Technician')->first();
        $customers = User::where('branch_id', $request->branch_id)->whereHas('roles', function ($query) use ($customerRole) {
            $query->where('role_id', $customerRole->id);
        })->latest()->get();
        $usersOption ='<option value="">Select User </option>';
        if($customers){
            foreach($customers as $customer)
            {
                $usersOption .= '<option value="'.  $customer->id .'">'. $customer->first_name. ' '.$customer->last_name	 .'</option>';
            }
        }

        $bays = Bay::where('branch_id', $request->branch_id)->get();
        $options='<option value="">Select Bay </option>';
        if($bays) {
            foreach($bays as $bay)
            {
                $options .= '<option value="'.  $bay->id .'">'. $bay->name	 .'</option>';
            }
        }

        return response()->json([
            'options' => $options,
            'userOption' => $usersOption
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerInquiry;
use App\Models\CustomerInquiryCsrCommentLog;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class CustomerInquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! Gate::allows('view customer inquiry')) {
            abort(403);
        }

        $userBranchId = Auth::user()->branch_id;
        $userCategory = Auth::user()->category;
        $userBranchName = Branch::where('id', $userBranchId)->select('name')->where('deleted_at', NULL)->first();

        $customer_inquiries = CustomerInquiry::with('location', 'product', 'csr');

                                            if(!empty($userCategory))
                                            {
                                                $customer_inquiries = $customer_inquiries->where('inquiry_category', $userCategory);
                                            }

                                            if($userBranchName->name !== 'Kingston')
                                            {
                                                $customer_inquiries = $customer_inquiries->whereHas('location.branches', function ($query) use ($userBranchId) {
                                                    $query->where('branches.id', $userBranchId);
                                                })
                                                ->latest()
                                                ->get();
                                            }else{
                                                $customer_inquiries = $customer_inquiries->latest()
                                                ->get();
                                            }

        return view('customer_inquiry.index', compact('customer_inquiries'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $customerInquiry)
    {
        if (! Gate::allows('edit customer inquiry')) {
            abort(403);
        }

        $adminRole = Role::where('name', 'Admin')->first();

        $users = User::whereHas('roles', function ($query) use ($adminRole) {
            $query->where('role_id', $adminRole->id);
        })->latest()->get();

        $customer_inquiry = CustomerInquiry::where('id', $customerInquiry)->with('product', 'location', 'csr')->first();

        return view('customer_inquiry.edit', compact('customer_inquiry', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $customerInquiry)
    {
        if (! Gate::allows('edit customer inquiry')) {
            abort(403);
        }

        $request->validate([
            'inquiry_status'    => 'required',
            'inquiry_attended_by_csr_comment'    => 'required',
        ]);

        CustomerInquiry::where('id', $customerInquiry)->update([
            'inquiry_status'            => $request->inquiry_status,
            'inquiry_attended_by_csr_id' => Auth::user()->id,
            'inquiry_attended_by_csr_comment'            => $request->inquiry_attended_by_csr_comment,
        ]);

        CustomerInquiryCsrCommentLog::create([
            'customer_inquiry_id' => $customerInquiry,
            'inquiry_status' => $request->inquiry_status,
            'inquiry_attended_by_csr_id' => Auth::user()->id,
            'inquiry_attended_by_csr_comment' => $request->inquiry_attended_by_csr_comment,
        ]);

        return redirect()->route('customer-inquiry.index')->with('success', 'Customer Inquiry updated successfully'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $customerInquiry)
    {
        if (! Gate::allows('delete customer inquiry')) {
            abort(403);
        }

        CustomerInquiry::where('id', $customerInquiry)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer Inquiry deleted successfully.'
        ]);
    }

    public function disableCustomerInquiry(Request $request)
    {
        $customer_inquiry = CustomerInquiry::where('id', $request->id)->first();
        $status = 1;
        $message = 'Customer Inquiry disabled successfully.';
        if($request->disable_customer_inquiry == 'disabled'){
            $status = 'active';
            $message = 'Customer Inquiry enabled successfully.';
        }else{
            $status = 'inactive';
            $message = 'Customer Inquiry disabled successfully.';
        }

        CustomerInquiry::where('id', $request->id)->update([
          'status' => $status  
        ]);

        return response()->json([
                'success' => true,
                'message' => $message
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerInquiry;
use App\Models\CustomerInquiryCsrCommentLog;
use App\Models\ProductParentCategories;
use App\Models\Branch;
use App\Models\Product;
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
        if (!Gate::allows('view customer inquiry')) {
            abort(403);
        }

        $user = Auth::user();
        $user->load('user_parent_categories');
        
        $userBranchId = $user->branch_id;
        $userCategory = $user->user_parent_categories->pluck('parent_category_name');
        
        $userBranchData = Branch::with('branch_locations.location')
                            ->where('id', $userBranchId)
                            ->whereNull('deleted_at')
                            ->first();

        $location_ids = $userBranchData->branch_locations->pluck('location')->pluck('id');

        $customer_inquiries = CustomerInquiry::with(['location', 'product', 'csr'])
            ->where('status' , '!=', 'delete')
            ->whereNull('deleted_at');

        if ($userBranchData->name !== 'Kingston') {
            $customer_inquiries = $customer_inquiries->whereIn('inquiry_location_id', $location_ids->toArray());
        }

        $customer_inquiries = $customer_inquiries->latest()->get();

        $final_customer_enquiry_data = [];

        if ($customer_inquiries->isNotEmpty()) {
            $productCategoryIds = Product::whereIn('id', $customer_inquiries->pluck('inquiry_product_id'))
                ->pluck('category_id', 'id');

            $parentCategories = ProductParentCategories::whereIn('product_category_id', $productCategoryIds->unique())
                ->whereNull('deleted_at')
                ->where('status', 'active')
                ->pluck('parent_category_name', 'product_category_id');

            foreach ($customer_inquiries as $customer_enquiry) {
                $category_id = $productCategoryIds[$customer_enquiry->inquiry_product_id] ?? null;

                if ($category_id && isset($parentCategories[$category_id]) && in_array($parentCategories[$category_id], $userCategory->toArray())) {
                    $final_customer_enquiry_data[] = $customer_enquiry;
                }
            }
        }
        
        return view('customer_inquiry.index', compact('final_customer_enquiry_data'));
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

        $customer_inquiry = CustomerInquiry::with('product', 'location', 'csr', 'csr_comments.csr_details')->where('id', $customerInquiry)->first();
        
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerInquiry;
use App\Models\CsrCommentLog;
use App\Models\ProductParentCategories;
use App\Models\Branch;
use App\Models\Product;
use App\Models\PromotionProducts;
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
        $userCategory = $user->user_parent_categories->pluck('parent_category_name')->toArray(); // Convert to array for quick lookup

        $userBranchData = Branch::with('branch_locations.location')
            ->where('id', $userBranchId)
            ->whereNull('deleted_at')
            ->first();

        $location_ids = $userBranchData->branch_locations->pluck('location.id')->toArray();

        // Fetch customer inquiries
        $customer_inquiries = CustomerInquiry::with(['location', 'product', 'csr'])
            ->where('status', '!=', 'delete')
            ->whereNull('deleted_at');

        if ($userBranchData->name !== 'Kingston') {
            $customer_inquiries->whereIn('inquiry_location_id', $location_ids);
        }

        $customer_inquiries = $customer_inquiries->latest()->get();

        $final_customer_enquiry_data = [];

        if ($customer_inquiries->isNotEmpty()) {
            // Fetch product category mappings
            $productCategoryIds = Product::whereIn(
                'id',
                $customer_inquiries->where('customer_inquiry_category', 'product')->pluck('inquiry_product_id')
            )->pluck('category_id', 'id')->toArray(); // Convert to array

            $parentCategories = ProductParentCategories::whereIn('product_category_id', array_unique($productCategoryIds))
                ->whereNull('deleted_at')
                ->where('status', 'active')
                ->pluck('parent_category_name', 'product_category_id')
                ->toArray(); // Convert to array

            // Fetch promotion product IDs and categories
            $promotionsIds = PromotionProducts::whereIn(
                'promotion_id',
                $customer_inquiries->where('customer_inquiry_category', 'promotion')->pluck('inquiry_product_id')
            )->pluck('product_id')->toArray();

            $promotionsCategoryIds = Product::whereIn('id', $promotionsIds)->pluck('category_id', 'id')->toArray();

            $promotionParentCategories = ProductParentCategories::whereIn(
                'product_category_id',
                array_unique($productCategoryIds)
            )->whereNull('deleted_at')
                ->where('status', 'active')
                ->pluck('parent_category_name', 'product_category_id')
                ->toArray(); // Convert to array

            foreach ($customer_inquiries as $customer_enquiry) {
                if ($customer_enquiry->customer_inquiry_category == 'product') {
                    $category_id = $productCategoryIds[$customer_enquiry->inquiry_product_id] ?? null;

                    if ($category_id && isset($parentCategories[$category_id]) && in_array($parentCategories[$category_id], $userCategory)) {
                        $final_customer_enquiry_data[] = $customer_enquiry;
                    }
                } else {
                    // Handle promotions
                    $promotion_id = $customer_enquiry->inquiry_product_id ?? null;

                    if ($promotion_id) {
                        $promotion_product_ids = PromotionProducts::where('promotion_id', $promotion_id)
                            ->pluck('product_id')
                            ->toArray();

                        $category_ids = array_values(array_intersect_key($promotionsCategoryIds, array_flip($promotion_product_ids)));

                        $category_parent_categories = array_unique(array_intersect_key($promotionParentCategories, array_flip($category_ids)));

                        if (!empty($category_parent_categories) && array_intersect($category_parent_categories, $userCategory)) {
                            $final_customer_enquiry_data[] = $customer_enquiry;
                        }
                    }
                }
            }
        }

        $branches = Branch::whereNull('deleted_at')->get();
        $selected_branch_id = 0;

        return view('customer_inquiry.index', compact('final_customer_enquiry_data', 'branches', 'selected_branch_id'));
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

        $customer_inquiry = CustomerInquiry::with('location', 'csr', 'csr_comments.csr_details')->where('id', $customerInquiry)->first();
        
        if($customer_inquiry->customer_inquiry_category == 'product')
        {
            $customer_inquiry->load('product');
        }else{
            $customer_inquiry->load('promotion.promotion_products.product_details', 'promotion.promotion_services.service_details', 'promotion.promotion_images');
        }
        
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

        CsrCommentLog::create([
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

    public function customerInquiryShowByBranch($id)
    {
        if (!Gate::allows('view customer inquiry')) {
            abort(403);
        }

        $user = Auth::user();
        $user->load('user_parent_categories');

        $userBranchId = $id;
        $userCategory = $user->user_parent_categories->pluck('parent_category_name')->toArray(); // Convert to array for quick lookup

        $userBranchData = Branch::with('branch_locations.location')
            ->where('id', $userBranchId)
            ->whereNull('deleted_at')
            ->first();

        $location_ids = $userBranchData->branch_locations->pluck('location.id')->toArray();

        // Fetch customer inquiries
        $customer_inquiries = CustomerInquiry::with(['location', 'product', 'csr'])
            ->where('status', '!=', 'delete')
            ->whereNull('deleted_at');

        if ($userBranchData->name !== 'Kingston') {
            $customer_inquiries->whereIn('inquiry_location_id', $location_ids);
        }

        $customer_inquiries = $customer_inquiries->latest()->get();

        $final_customer_enquiry_data = [];

        if ($customer_inquiries->isNotEmpty()) {
            // Fetch product category mappings
            $productCategoryIds = Product::whereIn(
                'id',
                $customer_inquiries->where('customer_inquiry_category', 'product')->pluck('inquiry_product_id')
            )->pluck('category_id', 'id')->toArray(); // Convert to array

            $parentCategories = ProductParentCategories::whereIn('product_category_id', array_unique($productCategoryIds))
                ->whereNull('deleted_at')
                ->where('status', 'active')
                ->pluck('parent_category_name', 'product_category_id')
                ->toArray(); // Convert to array

            // Fetch promotion product IDs and categories
            $promotionsIds = PromotionProducts::whereIn(
                'promotion_id',
                $customer_inquiries->where('customer_inquiry_category', 'promotion')->pluck('inquiry_product_id')
            )->pluck('product_id')->toArray();

            $promotionsCategoryIds = Product::whereIn('id', $promotionsIds)->pluck('category_id', 'id')->toArray();

            $promotionParentCategories = ProductParentCategories::whereIn(
                'product_category_id',
                array_unique($productCategoryIds)
            )->whereNull('deleted_at')
                ->where('status', 'active')
                ->pluck('parent_category_name', 'product_category_id')
                ->toArray(); // Convert to array

            foreach ($customer_inquiries as $customer_enquiry) {
                if ($customer_enquiry->customer_inquiry_category == 'product') {
                    $category_id = $productCategoryIds[$customer_enquiry->inquiry_product_id] ?? null;

                    if ($category_id && isset($parentCategories[$category_id]) && in_array($parentCategories[$category_id], $userCategory)) {
                        $final_customer_enquiry_data[] = $customer_enquiry;
                    }
                } else {
                    // Handle promotions
                    $promotion_id = $customer_enquiry->inquiry_product_id ?? null;

                    if ($promotion_id) {
                        $promotion_product_ids = PromotionProducts::where('promotion_id', $promotion_id)
                            ->pluck('product_id')
                            ->toArray();

                        $category_ids = array_values(array_intersect_key($promotionsCategoryIds, array_flip($promotion_product_ids)));

                        $category_parent_categories = array_unique(array_intersect_key($promotionParentCategories, array_flip($category_ids)));

                        if (!empty($category_parent_categories) && array_intersect($category_parent_categories, $userCategory)) {
                            $final_customer_enquiry_data[] = $customer_enquiry;
                        }
                    }
                }
            }
        }

        $branches = Branch::whereNull('deleted_at')->get();
        $selected_branch_id = $id;
        
        return view('customer_inquiry.index', compact('final_customer_enquiry_data', 'branches', 'selected_branch_id'));
    }
}

<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Inquiry;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class ReportsController extends Controller
{
  
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Inquiry::distinct()->select('vehicle')->get();

        return view('reports.index', compact('vehicles'));
    }

    public function fetchData(Request $request)
    {
        $filter = $request->filter;
        $perPage = 10;
        $data = '';
        if($request->filterValue == 'Inqueries') {
            if ($filter == 'Inqueries') {
                $data = Inquiry::latest();
            }
            if($filter == 'Day') {
                $data = Inquiry::whereDate('created_at', $request->date)->latest();
            }
            if($filter == 'Week') {
                $data = Inquiry::whereBetween('created_at', [$request->startDate, $request->endDate])->latest();
            }
            if($filter == 'Month') {
                $data = Inquiry::whereBetween('created_at', [$request->startDate, $request->endDate])->latest();
            }
            $html = '';
            $data = $data->paginate($perPage);
            foreach ($data as $key => $item)
            {
                $html .= '<tr>
                    <td>'.(($data->currentPage() - 1) * $perPage + $key + 1).'</td>
                    <td>'.$item['name'].'</td>
                    <td>'.$item['date'].'</td>
                    <td>'.$item['email'].'</td>
                    <td>'.$item['vehicle'].'</td>
                    <td>'.$item['licence_no'].'</td>
                </tr>';
            }
        } else if($request->filterValue == 'Product_Sold_Report') {
            $products = Product::latest()->get();
            $products_in_order = [];
            $unique_products = '';
            if ($filter == 'Product_Sold_Report') {
                $orders = Order::latest()->get();
                foreach ($orders as $key => $order) {
                    $cart = json_decode($order->cart_items, true);
                    if ($cart && isset($cart['products'])) {
                        $product_ids = array_column($cart['products'], 'id');
                        $products_for_order = $products->whereIn('id', $product_ids)->toArray();
                        $products_in_order = array_merge($products_in_order, $products_for_order);
                    }
                }
                $unique_products = array_values(array_unique($products_in_order, SORT_REGULAR));
            }

            if($filter == 'Day') {
                $orders = Order::whereDate('created_at', $request->date)->latest()->get();
                foreach ($orders as $key => $order) {
                    $cart = json_decode($order->cart_items, true);
                    if ($cart && isset($cart['products'])) {
                        $product_ids = array_column($cart['products'], 'id');
                        $products_for_order = $products->whereIn('id', $product_ids)->toArray();
                        $products_in_order = array_merge($products_in_order, $products_for_order);
                    }
                }
                $unique_products = array_values(array_unique($products_in_order, SORT_REGULAR));
            }

            if($filter == 'Week') {
                $orders = Order::whereBetween('created_at', [$request->startDate, $request->endDate])->latest()->get();
                foreach ($orders as $key => $order) {
                    $cart = json_decode($order->cart_items, true);
                    if ($cart && isset($cart['products'])) {
                        $product_ids = array_column($cart['products'], 'id');
                        $products_for_order = $products->whereIn('id', $product_ids)->toArray();
                        $products_in_order = array_merge($products_in_order, $products_for_order);
                    }
                }
                $unique_products = array_values(array_unique($products_in_order, SORT_REGULAR));
            }

            if($filter == 'Month') {
                $orders = Order::whereBetween('created_at', [$request->startDate, $request->endDate])->latest()->get();
                foreach ($orders as $key => $order) {
                    $cart = json_decode($order->cart_items, true);
                    if ($cart && isset($cart['products'])) {
                        $product_ids = array_column($cart['products'], 'id');
                        $products_for_order = $products->whereIn('id', $product_ids)->toArray();
                        $products_in_order = array_merge($products_in_order, $products_for_order);
                    }
                }
                $unique_products = array_values(array_unique($products_in_order, SORT_REGULAR));
            }

            $currentPage = $request->input('page', 1);
            $total = count($unique_products);
            $paginator = new LengthAwarePaginator(
                array_slice($unique_products, ($currentPage - 1) * $perPage, $perPage), $total, $perPage, $currentPage,
                [
                    'path' => $request->url(),
                    'query' => $request->query(),
                ]
            );
            $data = $paginator;
            $html = '';
            foreach ($data->items() as $key => $item) {
                $html .= '<tr>
                    <td>' . (($data->currentPage() - 1) * $perPage + $key + 1) . '</td>
                    <td>' . $item['product_name'] . '</td>
                    <td>' . $item['product_code'] . '</td>
                    <td>' . $item['manufacture_name'] . '</td>
                    <td>' . $item['cost_price'] . '</td>
                </tr>';
            }
        } else if($request->filterValue = 'Vehicle') {
            $data = Inquiry::where('vehicle', $request->vehicleName);
            if ($request->vehicleMileage) {
                $data = $data->where('mileage', $request->vehicleMileage);
            }
            if ($request->dob) {
                $data = $data->where('dob', $request->dob);
            }
            if ($request->vehicleLicense) {
                $data = $data->where('licence_no', $request->vehicleLicense);
            }

            $data = $data->latest()->paginate($perPage);
            $html = '';
            foreach ($data as $key => $item)
            {
                $html .= '<tr>
                    <td>'.(($data->currentPage() - 1) * $perPage + $key + 1).'</td>
                    <td>'.$item['name'].'</td>
                    <td>'.$item['date'].'</td>
                    <td>'.$item['email'].'</td>
                    <td>'.$item['vehicle'].'</td>
                    <td>'.$item['licence_no'].'</td>
                </tr>';
            }
        }

        return response()->json([
            'success' => true,
            'links'   => $data->links()->toHtml(),
            'data'    => $html
        ]);
    }

    public function getVehicleName(Request $request){
        $vehicleMileage = Inquiry::where('vehicle', $request->vehicleName)->whereNotNull('mileage')->distinct()->select('mileage')->get();
        $options='<option value="">Select Vehicle Mileage</option>';
        foreach($vehicleMileage as $mileage)
        {
            $options .= '<option value="'.  $mileage->mileage .'">'. $mileage->mileage	 .'</option>';
        }

        return response()->json([
            'options' => $options
        ]);
    }

    public function getVehicleMileage(Request $request) {
        $dob = Inquiry::where('mileage', $request->vehicleMileage)->distinct()->select('dob')->get();
        $options='<option value="">Select DOB</option>';
        foreach($dob as $value)
        {
            $options .= '<option value="'.  $value->dob .'">'. $value->dob	 .'</option>';
        }

        return response()->json([
            'options' => $options
        ]);
    }

    public function getDob(Request $request) {
        $vehicleLicense = Inquiry::where('dob', $request->dob)->whereNotNull('licence_no')->distinct()->select('licence_no')->get();
        $options='<option value="">Select License Number</option>';
        foreach($vehicleLicense as $license)
        {
            $options .= '<option value="'. $license->licence_no .'">'. $license->licence_no .'</option>';
        }

        return response()->json([
            'options' => $options
        ]);
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator);
        }

        $file = $request->file('file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));
        unset($data[0]);
        $header = [
            'product_code', 'category_id', 'product_name', 'manufacture_name', 'supplier', 'quantity', 'vehicle_category_id', 'description', 'cost_price', 'item_number'
        ];

        $errors = [];
        foreach ($data as $key => $row) {
            $row = array_combine($header, $row);
            $validator = Validator::make($row, [
                'product_code' => 'required',
                'category_id'  => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (!ProductCategory::where('id', $value)->exists()) {
                            $fail('The selected category id '. $value .' is invalid for row.');
                        }
                    }
                ],
                'product_name'       => 'required',
                'manufacture_name'   => 'required',
                'vehicle_category_id'  => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (!VehicleCategory::where('id', $value)->exists()) {
                            $fail('The selected vehicle category id '. $value .' is invalid.');
                        }
                    }
                ]
            ]);

            if ($validator->fails()) {
                $errors[$key] = $validator->errors()->all();
                continue;
            }

            Product::create([
                'product_code'         => $row['product_code'],
                'category_id'          => $row['category_id'],
                'product_name'         => $row['product_name'],
                'manufacture_name'     => $row['manufacture_name'],
                'supplier'             => $row['supplier'],
                'quantity'             => $row['quantity'],
                'vehicle_category_id'  => $row['vehicle_category_id'],
                'description'          => $row['description'],
                'cost_price'           => $row['cost_price'],
                'item_number'          => $row['item_number'],
            ]);
        }

        if (!empty($errors)) {
            return redirect()->route('products.index')->with('error', $errors);
        }

        return redirect()->route('products.index')->with('success', 'CSV file imported successfully.');
    }

    public function showCharts(){
        return view('reports.graphical-reports');
    }
    public function showLatestInqueries(){
        // Query to fetch the month name and total products for each month
       $inquiriesByMonth = Inquiry::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, DATE_FORMAT(created_at, "%b") as month_name, COUNT(*) as total_count')
        ->groupBy('month', 'month_name')
        ->orderBy('month', 'desc')
        ->take(12) // Limit to the last 12 months, adjust as needed
        ->get();

    return response()->json($inquiriesByMonth);
    }

    public function getInquiriesByStatus()
    {
        // Query to fetch inquiries grouped by status
        $pendingInquiries = Inquiry::where('status', 'pending')->get();
        $completedInquiries = Inquiry::where('status', 'completed')->get();
        $inProgressInquiries = Inquiry::where('status', 'in progress')->get();

        return response()->json([
            'pending' => $pendingInquiries,
            'completed' => $completedInquiries,
            'inProgress' => $inProgressInquiries,
        ]);
    }


}

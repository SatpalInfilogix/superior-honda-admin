<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\User;
use App\Models\VehicleCategory;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use App\Models\VehicleModel;
use App\Models\VehicleBrand;
use App\Models\VehicleType;
use App\Models\VehicleModelVariant;
use Illuminate\Http\Request;
use App\Imports\VehicleImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Gate::allows('view vehicle')) {
            abort(403);
        }

        $vehicles = Vehicle::with('customer')->whereHas('customer', function ($query) {
            $query->whereNull('deleted_at');
        })->latest()->get();

        return view('vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Gate::allows('create vehicle')) {
            abort(403);
        }

        $customerRole = Role::where('name', 'Customer')->first();

        $customers = User::whereHas('roles', function ($query) use ($customerRole) {
            $query->where('role_id', $customerRole->id);
        })->latest()->get();

        $categories = VehicleCategory::all();

        return view('vehicles.create', compact('customers' ,'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Gate::allows('create vehicle')) {
            abort(403);
        }

        $request->validate([
            'customer_id'  => 'required',
            'category_id'  => 'required',
            'vehicle_no'   => 'required',
            'year'         => 'required'
        ]);

        Vehicle::create([
            'cus_id'            => $request->customer_id,
            'category_id'       => $request->category_id,
            'brand_id'          => $request->brand_name,
            'model_id'          => $request->model_name,
            'varient_model_id'  => $request->model_variant_name,
            'type_id'           => $request->vehicle_type,
            'vehicle_no'        => $request->vehicle_no,
            'year'              => $request->year,
            'color'             => $request->color,
            'chasis_no'         => $request->chasis_no,
            'engine_no'         => $request->engine_no,
            'additional_details' => $request->additional_detail
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        if(!Gate::allows('edit vehicle')) {
            abort(403);
        }

        $customerRole = Role::where('name', 'Customer')->first();

        $customers = User::whereHas('roles', function ($query) use ($customerRole) {
            $query->where('role_id', $customerRole->id);
        })->latest()->get();

        $categories = VehicleCategory::all();
        $brands = VehicleBrand::all();
        $vehicleModels = VehicleModel::all();
        $vehicleTypes = VehicleType::all();
        $modelVariants = VehicleModelVariant::all();

        return view('vehicles.edit', compact('vehicle', 'categories', 'brands', 'vehicleModels', 'vehicleTypes','modelVariants', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        if(!Gate::allows('edit vehicle')) {
            abort(403);
        }
        $request->validate([
            'customer_id'  => 'required',
            'category_id'  => 'required',
            'vehicle_no'   => 'required',
            'year'         => 'required'
        ]);

        $vehicle = Vehicle::where('id', $vehicle->id)->first();

        $vehicle->update([
            'cus_id'            => $request->customer_id,
            'category_id'       => $request->category_id,
            'brand_id'          => $request->brand_name,
            'model_id'          => $request->model_name,
            'varient_model_id'  => $request->model_variant_name,
            'type_id'           => $request->vehicle_type,
            'vehicle_no'        => $request->vehicle_no,
            'year'              => $request->year,
            'color'             => $request->color,
            'chasis_no'         => $request->chasis_no,
            'engine_no'         => $request->engine_no,
            'additional_details' => $request->additional_detail
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $Vehicle)
    {
        if(!Gate::allows('delete vehicle')) {
            abort(403);
        }

        Vehicle::where('id', $Vehicle->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vehicle deleted successfully.'
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx',
        ]);

        $import = new VehicleImport;

        Excel::import($import, $request->file('file'));

        $errors = $import->getErrors();

        if (!empty($errors)) {
            Session::flash('import_errors', $errors);
            return redirect()->route('vehicles.index')->with('error', 'Some vehicles could not be imported. Please check the errors.');
        }

        return redirect()->route('vehicles.index')->with('success', 'Vehicles imported successfully.');
    }

    public function downloadExcel()
    {
        $spreadsheet = new Spreadsheet();
        
        $this->addUsersSheet($spreadsheet);
        
        $this->addVehicleCategoriesSheet($spreadsheet);
        $this->addVehicleTypeSheet($spreadsheet);
        $this->addVehicleBrandsSheet($spreadsheet);
        $this->addVehicleModelsSheet($spreadsheet);
        $this->addVehicleVariantsSheet($spreadsheet);

        $writer = new Xlsx($spreadsheet);
        $fileName = 'vehicle_configuration' . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }


    protected function addUsersSheet($spreadsheet)
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Users');

        $headers = ['ID', 'First Name', 'Last Name', 'Email', 'Phone Number'];
        $sheet->fromArray($headers, NULL, 'A1');

        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'Customer');
        })->get();

        foreach ($users as $key => $user) {
            $sheet->fromArray([$user->id, $user->first_name, $user->last_name, $user->email, $user->phone_number], NULL, 'A' . ($key + 2));
        }
    }

    protected function addVehicleCategoriesSheet($spreadsheet)
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Vehicle Categories');

        $headers = ['ID', 'Name'];
        $sheet->fromArray($headers, NULL, 'A1');

        $categories = VehicleCategory::all();

        foreach ($categories as $key => $category) {
            $sheet->fromArray([$category->id, $category->name], NULL, 'A' . ($key + 2));
        }
    }

    protected function addVehicleTypeSheet($spreadsheet)
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Vehicle Type');

        $headers = ['ID', 'Category ID', 'Vehicle Type'];
        $sheet->fromArray($headers, NULL, 'A1');

        $vehicleTypes = VehicleType::all();

        foreach ($vehicleTypes as $key => $vehicleType) {
            $sheet->fromArray([$vehicleType->id, $vehicleType->category_id, $vehicleType->vehicle_type], NULL, 'A' . ($key + 2));
        }
    }

    protected function addVehicleBrandsSheet($spreadsheet)
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Vehicle Brands');

        $headers = ['ID', 'Category ID', 'Brand Name'];
        $sheet->fromArray($headers, NULL, 'A1');

        $brands = VehicleBrand::all();

        foreach ($brands as $key => $brand) {
            $sheet->fromArray([$brand->id, $brand->category_id, $brand->brand_name], NULL, 'A' . ($key + 2));
        }
    }

    protected function addVehicleModelsSheet($spreadsheet)
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Vehicle Models');

        $headers = ['ID', 'Category ID', 'Brand ID', 'Model Name'];
        $sheet->fromArray($headers, NULL, 'A1');

        $models = VehicleModel::all();

        foreach ($models as $key => $model) {
            $sheet->fromArray([$model->id, $model->category_id, $model->brand_id, $model->model_name], NULL, 'A' . ($key + 2));
        }
    }

    protected function addVehicleVariantsSheet($spreadsheet)
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Vehicle Variants');

        $headers = ['ID', 'Category ID', 'Brand ID', 'Model ID', 'Variant Name'];
        $sheet->fromArray($headers, NULL, 'A1');

        $variants = VehicleModelVariant::all();

        foreach ($variants as $key => $variant) {
            $sheet->fromArray([$variant->id, $variant->category_id, $variant->brand_id, $variant->model_id, $variant->variant_name], NULL, 'A' . ($key + 2));
        }
    }
}

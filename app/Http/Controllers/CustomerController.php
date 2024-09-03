<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Str;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Gate::allows('view customer')) {
            abort(403);
        }

        $customerRole = Role::where('name', 'Customer')->first();

        $customers = User::whereHas('roles', function ($query) use ($customerRole) {
            $query->where('role_id', $customerRole->id);
        })->latest()->get();

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Gate::allows('create customer')) {
            abort(403);
        }

        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Gate::allows('create customer')) {
            abort(403);
        }

        $request->validate([
            'first_name'    => 'required',
            // 'last_name'     => 'required',
            // 'email'         => 'required',
            'email'         => 'required|unique:users',
            'phone_number' => 'required'
        ]);

        $user = User::orderByDesc('cus_code')->first();

        if (!$user) {
            $cusCode =  'CUS0001';
        } else {
            $numericPart = (int)substr($user->cus_code, 3);
            $nextNumericPart = str_pad($numericPart + 1, 4, '0', STR_PAD_LEFT);
            $cusCode = 'CUS' . $nextNumericPart;
        }

        user::create([
            'first_name'         => $request->first_name,
            'last_name'          => $request->last_name,
            'email'              => $request->email,
            'cus_code'           => $cusCode,
            'date_of_birth'      => $request->date_of_birth,
            'address'            => $request->address,
            'info'               => $request->info,
            'phone_number'       => $request->phone_number,
            'phone_lime'         => $request->phone_lime,
            'licence_no'         => $request->licence_no,
            'company_info'       => $request->company_info,
            'city'               => $request->city,
            'password'           => Hash::make($request->password),
        ])->assignRole('Customer');

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $customer)
    {
        if(!Gate::allows('edit customer')) {
            abort(403);
        }

        // $customer = User::where('id', $user->id)->first();

        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $customer)
    {
        if(!Gate::allows('edit customer')) {
            abort(403);
        }

        $request->validate([
            'first_name'    => 'required',
            // 'last_name'     => 'required',
            'phone_number' => 'required'
        ]);

        $customer = User::where('id', $customer->id)->first();

        $customer->update([
            'first_name'         => $request->first_name,
            'last_name'          => $request->last_name,
            'date_of_birth'      => $request->date_of_birth,
            'phone_number'       => $request->phone_number,
            'phone_lime'         => $request->phone_lime,
            'licence_no'         => $request->licence_no,
            'address'            => $request->address,
            'info'               => $request->info,
            'company_info'       => $request->company_info,
            'city'               => $request->city,
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $customer)
    {
        if(!Gate::allows('delete customer')) {
            abort(403);
        }

        $user = User::where('id', $customer->id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.'
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
            'first_name', 'last_name', 'email', 'phone_number','designation', 'additional_details','dob', 'password'
        ];

        $errors = [];
        $user = User::orderByDesc('cus_code')->first();
        if (!$user) {
            $cus_code =  'CUS0001';
        } else {
            $numericPart = (int)substr($user->cus_code, 3);
            $nextNumericPart = str_pad($numericPart + 1, 4, '0', STR_PAD_LEFT);
            $cus_code = 'CUS' . $nextNumericPart;
        }
        foreach ($data as $key => $row) {
            $row = array_combine($header, $row);

            $validator = Validator::make($row, [
                'first_name' => 'required',
                'last_name'  => 'required',
                'email'      => 'required|email|unique:users,email',
                'phone_number' => 'required',
                'password'   => 'required'
            ],
            [
                'email.unique' => 'The email '. $row['email'] .' has already been taken.',
            ]);

            if ($validator->fails()) {
                $errors[$key] = $validator->errors()->all();
                continue;
            }

            User::create([
                'first_name'         => $row['first_name'],
                'last_name'          => $row['last_name'],
                'email'              => $row['email'],
                'phone_number'       => $row['phone_number'],
                'designation'        => $row['designation'],
                'additional_details' => $row['additional_details'],
                'date_of_birth'      => $row['dob'],
                'cus_code'           => $cus_code,
                'password'           => Hash::make($row['password']),
            ])->assignRole('Customer');
        }

        if (!empty($errors)) {
            return redirect()->route('customers.index')->with('error', $errors);
        }

        return redirect()->route('customers.index')->with('success', 'CSV file imported successfully.');
    }
}

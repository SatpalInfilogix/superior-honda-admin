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
            'last_name'     => 'required',
            'email'         => 'required',
            'phone_digicel' => 'required'
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
            'phone_digicel'      => $request->phone_digicel,
            'phone_lime'         => $request->phone_lime,
            'lic_no'             => $request->lic_no,
            'address'            => $request->address,
            'password'           => Hash::make(Str::random(10)),
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
            'last_name'     => 'required',
            'phone_digicel' => 'required'
        ]);

        $customer = User::where('id', $customer->id)->first();

        $customer->update([
            'first_name'         => $request->first_name,
            'last_name'          => $request->last_name,
            'date_of_birth'      => $request->date_of_birth,
            'phone_digicel'      => $request->phone_digicel,
            'phone_lime'         => $request->phone_lime,
            'lic_no'             => $request->lic_no,
            'address'            => $request->address,
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
            'first_name', 'last_name', 'email', 'phone_digicel','phone_lime','dob','lic_no','address'
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
                'phone_digicel' => 'required',
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
                'phone_digicel'      => $row['phone_digicel'],
                'phone_lime'         => $row['phone_lime'],
                'date_of_birth'      => $row['dob'],
                'lic_no'             => $row['lic_no'],
                'address'            => $row['address'],
                'cus_code'           => $cus_code,
                'password'           => Hash::make(Str::random(10)),
            ])->assignRole('Customer');
        }

        if (!empty($errors)) {
            return redirect()->route('customers.index')->with('error', $errors);
        }

        return redirect()->route('customers.index')->with('success', 'CSV file imported successfully.');
    }
}

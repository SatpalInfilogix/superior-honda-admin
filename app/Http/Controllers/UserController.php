<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use App\Models\MasterConfiguration;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Gate::allows('view user')) {
            abort(403);
        }

        $customerRole = Role::where('name', 'Customer')->first();

        $users = User::whereDoesntHave('roles', function ($query) use ($customerRole) {
            $query->where('role_id', $customerRole->id);
        })->latest()->get();
        
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Gate::allows('create user')) {
            abort(403);
        }

        $designationType = MasterConfiguration::where('key', 'designations')->first();
        if($designationType && $designationType->value){
            $designations = json_decode($designationType->value);
        } else{
            $designations = [];
        }

        $branches = Branch::latest()->get();
        $roles = Role::where('name', '!=', 'Customer')->latest()->get();

        return view('users.create', compact('branches', 'roles', 'designations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Gate::allows('create user')) {
            abort(403);
        }

        $request->validate([
            'first_name'    => 'required',
            'last_name'     => 'required',
            'email'      => [
                'required',
                'email',
                Rule::unique('users')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })
            ],
            'designation'   => 'required',
            'role'          => 'required'
        ],
        [
            'email.unique'      => 'The email '. $request->email .' has already been taken.',
        ]);

        $user = User::orderByDesc('emp_id')->first();
        if (!$user) {
            $empId =  'EMP0001';
        } else {
            $numericPart = (int)substr($user->emp_id, 3);
            $nextNumericPart = str_pad($numericPart + 1, 4, '0', STR_PAD_LEFT);
            $empId = 'EMP' . $nextNumericPart;
        }

        user::create([
            'first_name'         => $request->first_name,
            'last_name'          => $request->last_name,
            'email'              => $request->email,
            'designation'        => $request->designation,
            'branch_id'          => $request->branch,
            'emp_id'             => $empId,
            'additional_details' => $request->additional_detail,
            'date_of_birth'      => $request->date_of_birth,
            'password'           => Hash::make($request->password),
        ])->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
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
    public function edit(User $user)
    {
        if(!Gate::allows('edit user')) {
            abort(403);
        }

        $branches = Branch::latest()->get();
        $designationType = MasterConfiguration::where('key', 'designations')->first();
        if($designationType && $designationType->value){
            $designations = json_decode($designationType->value);
        } else{
            $designations = [];
        }
        $roles = Role::where('name', '!=', 'Customer')->latest()->get();

        return view('users.edit', compact('user', 'branches', 'roles', 'designations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if(!Gate::allows('edit user')) {
            abort(403);
        }

        $request->validate([
            'first_name'  => 'required',
            'last_name'   => 'required',
        ]);

        $user = User::where('id', $user->id)->first();
        $user->update([
            'first_name'         => $request->first_name,
            'last_name'          => $request->last_name,
            'branch_id'          => $request->branch,
            'date_of_birth'      => $request->date_of_birth,
            'additional_details' => $request->additional_detail,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if(!Gate::allows('delete user')) {
            abort(403);
        }

        $user = User::where('id', $user->id)->delete();
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
            'first_name', 'last_name', 'email', 'designation', 'additional_details','dob','role', 'password'
        ];

        $errors = [];
        $branch_ids = [];
        $user = User::orderByDesc('emp_id')->first();
        if (!$user) {
            $empId =  'EMP0001';
        } else {
            $numericPart = (int)substr($user->emp_id, 3);
            $nextNumericPart = str_pad($numericPart + 1, 4, '0', STR_PAD_LEFT);
            $empId = 'EMP' . $nextNumericPart;
        }

        $validRoles = Role::pluck('name')->toArray();
        foreach ($data as $key => $row) {
            $row = array_combine($header, $row);
            if (!in_array($row['role'], $validRoles)) {
                $errors[$key][] = 'Role ' . $row['role'] . ' is not valid.';
                continue;
            }

            $dob = \Carbon\Carbon::parse($row['dob'])->format('Y-m-d');
            $validator = Validator::make($row, [
                'first_name' => 'required',
                'last_name'  => 'required',
                'email'      => [
                    'required',
                    'email',
                    Rule::unique('users')->where(function ($query) {
                        return $query->whereNull('deleted_at');
                    })
                ],
                'dob'        => 'required|date_format:Y-m-d',
                'role'       => 'required',
                'password'   => 'required'
            ],
            [
                'email.unique' => 'The email '. $row['email'] .' has already been taken.',
            ]);

            if ($validator->fails()) {
                $errors[$key] = $validator->errors()->all();
                continue;
            }

            // $branch = Branch::where('id', $row['branch_id'])->first();
            // if(!$branch){
            //     $branch_ids[$key][] = 'Branch id '. $row['branch_id'] .' not match.';
            //     continue;
            // }

            User::create([
                'first_name'         => $row['first_name'],
                'last_name'          => $row['last_name'],
                'email'              => $row['email'],
                'designation'        => $row['designation'],
                'emp_id'             => $empId,
                'password'           => Hash::make($row['password']),
                'additional_details' => $row['additional_details'],
                'date_of_birth'      => $dob,
            ])->assignRole($row['role']);
        }

        if (!empty($errors)) {
            return redirect()->route('users.index')->with('error', $errors);
        }

        if(!empty($branch_ids)) {
            return redirect()->route('users.index')->with('error', $branch_ids);
        }

        return redirect()->route('users.index')->with('success', 'CSV file imported successfully.');
    }
}

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

        $users = user::latest()->get();
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

        $branches = Branch::latest()->get();
        $roles = Role::where('name', '!=', 'Customer')->latest()->get();
        return view('users.create', compact('branches', 'roles'));
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
            'email'         => 'required',
            'designation'   => 'required',
            'role'          => 'required'
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
            'password'           => Hash::make(Str::random(10)),
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
        $roles = Role::where('name', '!=', 'Customer')->latest()->get();
        return view('users.edit', compact('user', 'branches', 'roles'));
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
            'designation' => 'required',
            'role'        => 'required'
        ]);

        user::where('id', $user->id)->update([
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
        $header = array_shift($data);

        $errors = [];
        foreach ($data as $key => $row) {
            $row = array_combine($header, $row);
             echo"<pre>"; print_r($row); die();
            $validator = Validator::make($row, [
                'First Name' => 'required',
                'Last Name'  => 'required',
                'Role'       => 'required',
                'Email' => 'required|email|unique:users,email',
            ],
            [
                'Email.unique' => 'The email '. $row['Email'] .' has already been taken.',
            ]);

            if ($validator->fails()) {
                $errors[$key] = $validator->errors()->all();
                continue;
            }

            User::create([
                'first_name'=> $row['First Name'],
                'last_name' => $row['Last Name'],
                'email'     => $row['Email'],
                'password'  => Hash::make(Str::random(10)),
            ])->assignRole($row['Role']);
        }

        if (!empty($errors)) {
            return redirect()->route('users.index')->with('error', $errors);
        }

        return redirect()->route('users.index')->with('success', 'CSV file imported successfully.');
    }
}

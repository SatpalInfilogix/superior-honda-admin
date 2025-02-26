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
use App\Models\UserParentCategories;
use Carbon\Carbon;
use App\Models\Location;

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
        })->with('user_parent_categories')->latest()->get();

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

        $branches = Branch::with('branch_locations')->whereHas('branch_locations', function ($query) {
            $query->whereNull('deleted_at');
        })->get();
        
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
            'role'          => 'required',
            'parent_category_id' => 'required',
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

        $parent_categories = $request->parent_category_id;

        foreach($parent_categories as $parent_category)
        {
            $parent_category_data = [];
            $parent_category_data['user_id'] = $user->id;
            $parent_category_data['parent_category_name'] = $parent_category;
            
            UserParentCategories::create($parent_category_data);
        }

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

        // get user parent categories
        $user->load('user_parent_categories');

        $branches = Branch::with('branch_locations')->whereHas('branch_locations', function ($query) {
            $query->whereNull('deleted_at');
        })->latest()->get();
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
            'parent_category_id' => 'required'
        ]);

        $user = User::where('id', $user->id)->first();
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->update([
            'first_name'         => $request->first_name,
            'last_name'          => $request->last_name,
            'branch_id'          => $request->branch,
            'date_of_birth'      => $request->date_of_birth,
            'additional_details' => $request->additional_detail,
        ]);

        // old parent categories
        $old_parent_categories = UserParentCategories::where('user_id', $user->id)->get()->pluck('parent_category_name')->toArray();

        // new parent categories
        $new_parent_categories = $request->parent_category_id;

        // categories to add (new but not in old)
        $categories_to_add = array_diff($new_parent_categories, $old_parent_categories);

        // categories to delete (old but not in new)
        $categories_to_delete = array_diff($old_parent_categories, $new_parent_categories);

        // Add new categories
        foreach ($categories_to_add as $category_to_add) {
            UserParentCategories::create([
                'user_id' => $user->id,
                'parent_category_name' => $category_to_add
            ]);
        }

        // Delete removed categories
        foreach ($categories_to_delete as $category_to_delete) {
            UserParentCategories::where('user_id', $user->id)
                ->where('parent_category_name', $category_to_delete)
                ->delete();
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }


    public function disableUser(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $status = 'Active';
        $message = 'User disabled successfully.';
        if($request->disable_user == 'disabled'){
            $status = 'Active';
            $message = 'User enabled successfully.';
        }else{
            $status = 'Inactive';
            $message = 'User disabled successfully.';
        }

        User::where('id', $request->id)->update([
          'status' => $status  
        ]);

        return response()->json([
                'success' => true,
                'message' => $message
        ]);
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

        $parent_categories = UserParentCategories::where('user_id', $user->id)->delete();

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
            'first_name', 'last_name', 'email', 'designation', 'additional_details','dob','role', 'category', 'password'
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
                'category'       => 'required',
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
                'category'           => strtolower($row['category']),
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

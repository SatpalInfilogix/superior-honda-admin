<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where('id', Auth::id())->first();
        $roles = Role::latest()->get();

        return view('profile.index', compact('user', 'roles'));
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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user = User::where('id', Auth::id())->first();
        $oldProfile = NULL;
        if($user != '') {
            $oldProfile = $user->profile_picture;
        }

        if ($request->hasFile('profile_image'))
        {
            $file = $request->file('profile_image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile-pic/'), $filename);
        }

        $user->update([
            'first_name'      => $request->first_name,
            'last_name'       => $request->last_name,
            'date_of_birth'   => $request->date_of_birth,
            'profile_picture' => isset($filename) ? 'uploads/profile-pic/'. $filename : $oldProfile,
        ]);

        if($request->password && $request->password == $request->confirm_password) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('profile.index')->with('message', 'Profile updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}

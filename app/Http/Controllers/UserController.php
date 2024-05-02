<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facade\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function login(Request $request)
    {
        echo"<pre>"; print_r($request->all()); die();
        // $validator =  Validator::make($request->all(), [
        //     'email'     => 'required',
        //     'password'  => 'required'
        // ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user->token = $user->createToken('MyApp')->plainTextToken;
                return redirect(route('/dashboard'));
            } else {
                return Redirect::route("/login")->with('error-message','Invalid Credential.');
            }
        } else {
            return Redirect::route("/login")->with('error-message','User Not found.');
        }
    }
}

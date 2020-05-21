<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\User;
use App\Events\UserCreated;

class UserController extends Controller
{
    public function showRegistrationPage()
    {
        return view('user.register');
    }

    public function register(Request $request)
    {
        $request->validate(
            [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
            ]
        );

        $user = User::create(
            [
            'name' => $request->name,
            'email' => $request->email,
            'password' =>$request->password
            ]
        );
        event(new UserCreated($user));
    }
}

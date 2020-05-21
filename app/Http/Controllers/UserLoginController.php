<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{

    public function showLoginPage()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $request->validate(
            [
            'email' => 'required',
            'password' => 'required'
            ]
        );
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('/');
        }
        return redirect()->back()->withErrors('Invalid email or password');
    }
}

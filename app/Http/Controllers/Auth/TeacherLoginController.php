<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherLoginController extends Controller
{
    public function __construct() {
        $this->middleware('guest:teacher')->except('logout');
    }

    public function login(Request $request) {

        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $status = Auth::guard('teacher')->attempt($credentials, $request->remember);

        if($status) {
            return redirect()->intended(route('home-teacher'));
        }

        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->intended(route('initial'));
    }

    public function index() {
        return view('auth.login-teacher');
    }
}

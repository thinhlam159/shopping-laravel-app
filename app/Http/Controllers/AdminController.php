<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function loginAdmin()
    {
        if(auth()->check()) {
            return redirect()->to('/home');
        }
        return view('login');
    }

    public function postLoginAdmin(Request $request)
    {
        $remember = $request->has('remember-me') ? true : false;
        if(auth()->attempt([
            'name'=>$request->name,
            'password'=>$request->password,
        ], $remember)) {
            return redirect()->to('/home');
        } else {
            return redirect()->back()->with('status', 'Sai tên đăng nhập hoặc mật khẩu!');
        }
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/home');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        }
    }
}

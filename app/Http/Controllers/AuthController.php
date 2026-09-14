<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'petani_id' => 'required|string|max:50'
        ]);

        // Simple login just by providing an ID
        $request->session()->put('petani_id', $request->input('petani_id'));

        return redirect()->route('dashboard.index');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('petani_id');
        return redirect()->route('login');
    }
}

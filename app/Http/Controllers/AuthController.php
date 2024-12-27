<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RT;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function proses_login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email', 
            'password' => 'required|min:6', 
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            switch ($user->role_id) {
                case 1:
                    return redirect()->intended('dashboardAdmin');
                case 2: 
                    return redirect()->intended('dashboardApproval');
                default:
                    return redirect()->intended('/')->with('status', 'Role tidak dikenali.');
            }
        }

        return redirect('/')
            ->withInput()
            ->withErrors(['login_gagal' => 'Email atau password yang dimasukkan salah.']);
    }



    public function logout(Request $request)
    {
        $request->session()->flush();

        Auth::logout();

        return Redirect('login');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $admin = User::where('email', $credentials['email'])->where('role', 'admin')->first();

        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            session([
                'admin_logged_in' => true,
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
                'admin_email' => $admin->email
            ]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Email ose fjalëkalimi është i gabuar.'])->withInput();
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_id', 'admin_name', 'admin_email']);
        return redirect()->route('admin.login');
    }
}
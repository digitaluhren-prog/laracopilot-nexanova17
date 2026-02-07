<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        if (session('user_logged_in')) {
            return redirect()->route('user.dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'phone' => $validated['phone'] ?? null,
            'city' => $validated['city'] ?? null
        ]);

        session([
            'user_logged_in' => true,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_role' => $user->role
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Llogaria u krijua me sukses!');
    }

    public function showLogin()
    {
        if (session('user_logged_in')) {
            return redirect()->route('user.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $credentials['email'])->where('role', 'user')->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            session([
                'user_logged_in' => true,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_role' => $user->role
            ]);
            return redirect()->route('user.dashboard')->with('success', 'Mirë se erdhe!');
        }

        return back()->withErrors(['email' => 'Email ose fjalëkalimi është i gabuar.'])->withInput();
    }

    public function logout()
    {
        session()->forget(['user_logged_in', 'user_id', 'user_name', 'user_email', 'user_role']);
        return redirect()->route('home')->with('success', 'U shkëputët me sukses.');
    }
}
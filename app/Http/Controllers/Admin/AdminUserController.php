<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $users = User::where('role', 'user')
            ->withCount('listings')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }
    
    public function edit($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $user = User::where('role', 'user')->findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }
    
    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100'
        ]);
        
        $user = User::where('role', 'user')->findOrFail($id);
        $user->update($validated);
        
        return redirect()->route('admin.users.index')->with('success', 'Përdoruesi u përditësua me sukses.');
    }
    
    public function destroy($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $user = User::where('role', 'user')->findOrFail($id);
        $user->delete();
        
        return redirect()->route('admin.users.index')->with('success', 'Përdoruesi u fshi me sukses.');
    }
}
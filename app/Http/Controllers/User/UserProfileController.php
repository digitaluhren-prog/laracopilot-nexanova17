<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function dashboard()
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login');
        }
        
        $userId = session('user_id');
        $totalListings = Listing::where('user_id', $userId)->count();
        $approvedListings = Listing::where('user_id', $userId)->where('status', 'approved')->count();
        $pendingListings = Listing::where('user_id', $userId)->where('status', 'pending')->count();
        $rejectedListings = Listing::where('user_id', $userId)->where('status', 'rejected')->count();
        
        $recentListings = Listing::with('category')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('user.dashboard', compact(
            'totalListings', 'approvedListings', 'pendingListings', 
            'rejectedListings', 'recentListings'
        ));
    }
    
    public function profile()
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login');
        }
        
        $user = User::findOrFail(session('user_id'));
        return view('user.profile', compact('user'));
    }
    
    public function updateProfile(Request $request)
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:500',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed'
        ]);
        
        $user = User::findOrFail(session('user_id'));
        
        $user->name = $validated['name'];
        $user->phone = $validated['phone'];
        $user->city = $validated['city'];
        $user->bio = $validated['bio'];
        
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Fjalëkalimi aktual është i gabuar.']);
            }
            $user->password = Hash::make($validated['new_password']);
        }
        
        $user->save();
        session(['user_name' => $user->name]);
        
        return back()->with('success', 'Profili u përditësua me sukses!');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Listing;
use App\Models\Category;
use App\Models\Rating;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $totalUsers = User::where('role', 'user')->count();
        $totalListings = Listing::count();
        $pendingListings = Listing::where('status', 'pending')->count();
        $approvedListings = Listing::where('status', 'approved')->count();
        $totalCategories = Category::count();
        $totalRatings = Rating::count();
        $pendingRatings = Rating::where('approved', false)->count();
        
        $recentUsers = User::where('role', 'user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        $recentListings = Listing::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        $listingsByCategory = Category::withCount('listings')->get();
        $listingsByStatus = [
            'pending' => $pendingListings,
            'approved' => $approvedListings,
            'rejected' => Listing::where('status', 'rejected')->count()
        ];
        
        return view('admin.dashboard', compact(
            'totalUsers', 'totalListings', 'pendingListings', 'approvedListings',
            'totalCategories', 'totalRatings', 'pendingRatings', 'recentUsers',
            'recentListings', 'listingsByCategory', 'listingsByStatus'
        ));
    }
}
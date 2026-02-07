<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('active', true)->withCount('approvedListings')->get();
        
        $query = Listing::with(['category', 'user'])
            ->where('status', 'approved');
        
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->has('city') && $request->city) {
            $query->where('city', $request->city);
        }
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $listings = $query->orderBy('created_at', 'desc')->paginate(12);
        $cities = Listing::where('status', 'approved')->distinct()->pluck('city');
        
        return view('welcome', compact('listings', 'categories', 'cities'));
    }
    
    public function show($id)
    {
        $listing = Listing::with(['category', 'user', 'approvedRatings.user'])
            ->where('status', 'approved')
            ->findOrFail($id);
        
        $listing->increment('view_count');
        
        return view('listing-detail', compact('listing'));
    }
}
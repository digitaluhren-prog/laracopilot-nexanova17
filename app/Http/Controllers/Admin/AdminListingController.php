<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;

class AdminListingController extends Controller
{
    public function index(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $query = Listing::with(['user', 'category']);
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $listings = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.listings.index', compact('listings'));
    }
    
    public function pending()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $listings = Listing::with(['user', 'category'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.listings.pending', compact('listings'));
    }
    
    public function approve($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $listing = Listing::findOrFail($id);
        $listing->status = 'approved';
        $listing->rejection_reason = null;
        $listing->save();
        
        return back()->with('success', 'Listimi u aprovua me sukses.');
    }
    
    public function reject(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);
        
        $listing = Listing::findOrFail($id);
        $listing->status = 'rejected';
        $listing->rejection_reason = $validated['rejection_reason'];
        $listing->save();
        
        return back()->with('success', 'Listimi u refuzua.');
    }
    
    public function destroy($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        Listing::findOrFail($id)->delete();
        
        return back()->with('success', 'Listimi u fshi me sukses.');
    }
}
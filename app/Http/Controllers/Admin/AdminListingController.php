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

        $listings = Listing::latest()->paginate(10);
        return view('admin.listings.index', compact('listings'));
    }

public function show(Listing $listing)
{
    return view('admin.listings.show', compact('listing'));
}

public function approve(Listing $listing)
{
    $listing->update(['status' => 'approved', 'rejection_reason' => null]);
    return back()->with('success', 'Listimi u aprovua me sukses.');
}

public function reject(Request $request, Listing $listing)
{
    $request->validate([
        'rejection_reason' => 'required|string|max:1000',
    ]);

    $listing->update([
        'status' => 'rejected',
        'rejection_reason' => $request->rejection_reason,
    ]);

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
    public function pending()
{
    $listings = Listing::where('status', 'pending')->latest()->paginate(10);
    return view('admin.listings.index', compact('listings'));
}
}
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

    public function show($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $listing = Listing::findOrFail($id);
        return view('admin.listings.show', compact('listing'));
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
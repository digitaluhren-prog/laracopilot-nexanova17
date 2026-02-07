<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class AdminRatingController extends Controller
{
    public function index(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $query = Rating::with(['listing.category', 'user'])
            ->orderBy('created_at', 'desc');

        // Filter by approval status
        if ($request->has('approved') && $request->approved !== '') {
            $query->where('approved', $request->approved == '1');
        }

        $ratings = $query->paginate(20);

        return view('admin.ratings.index', compact('ratings'));
    }

    public function approve($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $rating = Rating::findOrFail($id);
        $rating->approved = true;
        $rating->save();

        // Update listing rating average
        $rating->listing->updateRatingAverage();

        return back()->with('success', 'Vlerësimi u aprovua me sukses.');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $rating = Rating::findOrFail($id);
        $listing = $rating->listing;
        $rating->delete();

        // Update listing rating average
        $listing->updateRatingAverage();

        return back()->with('success', 'Vlerësimi u fshi me sukses.');
    }
}
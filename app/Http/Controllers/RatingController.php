<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Listing;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request, $id)
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login')->with('error', 'Duhet të kyçeni për të vlerësuar.');
        }

        $listing = Listing::findOrFail($id);

        // Check if user already rated this listing
        $existingRating = Rating::where('listing_id', $listing->id)
            ->where('user_id', session('user_id'))
            ->first();

        if ($existingRating) {
            return back()->with('error', 'Ju keni vlerësuar tashmë këtë listim.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Rating::create([
            'listing_id' => $listing->id,
            'user_id' => session('user_id'),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'approved' => false, // Requires admin approval
        ]);

        return back()->with('success', 'Vlerësimi juaj është dërguar për moderim. Do të shfaqet pas aprovimit nga administratorët.');
    }

    public function destroy($id)
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login');
        }

        $rating = Rating::findOrFail($id);

        // Only allow user to delete their own rating
        if ($rating->user_id !== session('user_id')) {
            return back()->with('error', 'Nuk keni të drejtë të fshini këtë vlerësim.');
        }

        $rating->delete();
        $rating->listing->updateRatingAverage();

        return back()->with('success', 'Vlerësimi juaj u fshi me sukses.');
    }
}
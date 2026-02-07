<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\ListingImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    public function index()
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login');
        }

        $listings = Listing::where('user_id', session('user_id'))
            ->with(['category', 'images'])
            ->latest()
            ->paginate(10);

        return view('user.listings.index', compact('listings'));
    }

    public function create()
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login');
        }

        $categories = Category::where('active', true)->get();
        return view('user.listings.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'category_id' => 'required|exists:categories,id',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $listing = Listing::create([
            ...$validated,
            'user_id' => session('user_id'),
            'status' => 'pending',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('listings', 'public');
                $listing->images()->create([
                    'image_path' => $path,
                    'order' => $index,
                ]);
            }
        }

        return redirect()
            ->route('user.listings.index')
            ->with('success', 'Listimi u krijua me sukses dhe është në pritje të aprovimit.');
    }

    public function edit($id)
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login');
        }

        $listing = Listing::where('id', $id)
            ->where('user_id', session('user_id'))
            ->with('images')
            ->firstOrFail();

        $categories = Category::where('active', true)->get();
        return view('user.listings.edit', compact('listing', 'categories'));
    }

    public function update(Request $request, $id)
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login');
        }

        $listing = Listing::where('id', $id)
            ->where('user_id', session('user_id'))
            ->with('images')
            ->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'category_id' => 'required|exists:categories,id',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'exists:listing_images,id',
        ]);

        // Remove selected images
        if ($request->filled('remove_images')) {
            foreach ($request->remove_images as $imageId) {
                $image = $listing->images()->where('id', $imageId)->first();
                if ($image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }

            // Reorder remaining images
            $listing->images()->get()->values()->each(function ($image, $index) {
                $image->update(['order' => $index]);
            });
        }

        // Add new images
        if ($request->hasFile('images')) {
            $startOrder = ($listing->images()->max('order') ?? -1) + 1;

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('listings', 'public');
                $listing->images()->create([
                    'image_path' => $path,
                    'order' => $startOrder + $index,
                ]);
            }
        }

        // Reset rejected listings back to pending
        if ($listing->status === 'rejected') {
            $validated['status'] = 'pending';
            $validated['rejection_reason'] = null;
        }

        $listing->update($validated);

        return redirect()
            ->route('user.listings.index')
            ->with('success', 'Listimi u përditësua me sukses.');
    }

    public function destroy($id)
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login');
        }

        $listing = Listing::where('id', $id)
            ->where('user_id', session('user_id'))
            ->with('images')
            ->firstOrFail();

        foreach ($listing->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $listing->delete();

        return redirect()
            ->route('user.listings.index')
            ->with('success', 'Listimi u fshi me sukses.');
    }
}
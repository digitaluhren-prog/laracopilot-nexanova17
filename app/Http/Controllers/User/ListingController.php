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
            ->orderBy('created_at', 'desc')
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
        ], [
            'images.*.image' => 'Secila foto duhet të jetë në formatin JPG, PNG ose WEBP.',
            'images.*.max' => 'Secila foto nuk duhet të kalojë 2MB.',
        ]);

        $validated['user_id'] = session('user_id');
        $validated['status'] = 'pending';

        $listing = Listing::create($validated);

        // Handle multiple images - first image becomes main/cover image
        if ($request->hasFile('images')) {
            $order = 0;
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('listings', 'public');
                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image_path' => $imagePath,
                    'order' => $order++,
                ]);
            }
        }

        return redirect()->route('user.listings.index')
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
        ], [
            'images.*.image' => 'Secila foto duhet të jetë në formatin JPG, PNG ose WEBP.',
            'images.*.max' => 'Secila foto nuk duhet të kalojë 2MB.',
        ]);

        // Handle image removal
        if ($request->has('remove_images') && is_array($request->remove_images)) {
            foreach ($request->remove_images as $imageId) {
                $image = ListingImage::where('id', $imageId)
                    ->where('listing_id', $listing->id)
                    ->first();
                if ($image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
            
            // Reorder remaining images
            $remainingImages = $listing->images()->orderBy('order')->get();
            foreach ($remainingImages as $index => $image) {
                $image->update(['order' => $index]);
            }
        }

        // Handle new images upload
        if ($request->hasFile('images')) {
            $maxOrder = $listing->images()->max('order') ?? -1;
            $order = $maxOrder + 1;
            
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('listings', 'public');
                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image_path' => $imagePath,
                    'order' => $order++,
                ]);
            }
        }

        // If listing was rejected and now edited, reset to pending
        if ($listing->status === 'rejected') {
            $validated['status'] = 'pending';
            $validated['rejection_reason'] = null;
        }

        $listing->update($validated);

        return redirect()->route('user.listings.index')
            ->with('success', 'Listimi u përditësua me sukses.');
    }

    public function destroy($id)
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login');
        }

        $listing = Listing::where('id', $id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        // Delete all images
        foreach ($listing->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $listing->delete();

        return redirect()->route('user.listings.index')
            ->with('success', 'Listimi u fshi me sukses.');
    }
}
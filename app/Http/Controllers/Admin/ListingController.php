<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\Category;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $status = request('status');
        $search = request('search');

        $listings = Listing::with(['user', 'category', 'images'])
            ->when($status, function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when($search, function($query) use ($search) {
                return $query->where(function($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%')
                      ->orWhereHas('user', function($userQuery) use ($search) {
                          $userQuery->where('name', 'like', '%' . $search . '%');
                      });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.listings.index', compact('listings'));
    }

    public function show($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $listing = Listing::with(['user', 'category', 'images', 'approvedRatings.user'])->findOrFail($id);

        return view('admin.listings.show', compact('listing'));
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $listing = Listing::with('images')->findOrFail($id);
        $categories = Category::where('active', true)->get();

        return view('admin.listings.edit', compact('listing', 'categories'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $listing = Listing::findOrFail($id);

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

        $listing->update($validated);

        return redirect()->route('admin.listings.show', $listing->id)
            ->with('success', 'Listimi u përditësua me sukses.');
    }

    public function approve($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $listing = Listing::findOrFail($id);
        $listing->update([
            'status' => 'approved',
            'rejection_reason' => null
        ]);

        return redirect()->back()->with('success', 'Listimi u aprovua me sukses.');
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
        $listing->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason']
        ]);

        return redirect()->back()->with('success', 'Listimi u refuzua.');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $listing = Listing::findOrFail($id);

        // Delete all images
        foreach ($listing->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $listing->delete();

        return redirect()->route('admin.listings.index')->with('success', 'Listimi u fshi me sukses.');
    }
}
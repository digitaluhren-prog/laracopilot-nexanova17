<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'user_id',
        'city',
        'address',
        'phone',
        'email',
        'website',
        'status',
        'rejection_reason',
        'view_count',
        'rating_average',
        'rating_count',
    ];

    protected $casts = [
        'view_count' => 'integer',
        'rating_average' => 'decimal:1',
        'rating_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function approvedRatings()
    {
        return $this->hasMany(Rating::class)->where('approved', true);
    }

    public function images()
    {
        return $this->hasMany(ListingImage::class)->orderBy('order');
    }

    /**
     * Main image (cover) or category fallback
     */
    public function getMainImage()
    {
        $image = $this->images()->first();

        if ($image) {
            return $image->url;
        }

        return $this->category?->image
            ? asset('storage/' . $this->category->image)
            : asset('images/default-listing.jpg');
    }

    public function hasImages()
    {
        return $this->images()->exists();
    }

    public function updateRatingAverage()
    {
        $approvedRatings = $this->ratings()->where('approved', true)->get();

        $this->rating_average = $approvedRatings->count()
            ? round($approvedRatings->avg('rating'), 1)
            : 0;

        $this->rating_count = $approvedRatings->count();

        $this->save();
    }
}
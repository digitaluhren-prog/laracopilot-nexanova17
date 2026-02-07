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
        return $this->hasMany(Rating::class)->where('approved', true)->orderBy('created_at', 'desc');
    }

    public function images()
    {
        return $this->hasMany(ListingImage::class)->orderBy('order');
    }

    public function updateRatingAverage()
    {
        $approvedRatings = $this->ratings()->where('approved', true)->get();
        
        if ($approvedRatings->count() > 0) {
            $this->rating_average = $approvedRatings->avg('rating');
            $this->rating_count = $approvedRatings->count();
        } else {
            $this->rating_average = 0;
            $this->rating_count = 0;
        }
        
        $this->save();
    }

    /**
     * Get the main/cover image (first image)
     */
    public function getMainImage()
    {
        $firstImage = $this->images()->first();
        return $firstImage ? $firstImage->getImageUrl() : null;
    }

    /**
     * Check if listing has any images
     */
    public function hasImages()
    {
        return $this->images()->count() > 0;
    }
}
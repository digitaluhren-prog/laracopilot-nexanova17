<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingImage extends Model
{
    protected $fillable = [
        'listing_id',
        'image_path',
        'order',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    /**
     * Get the full URL of the image
     */
    public function getImageUrl()
    {
        return asset('storage/' . $this->image_path);
    }
}
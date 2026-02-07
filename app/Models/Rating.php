<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'listing_id',
        'user_id',
        'rating',
        'comment',
        'approved'
    ];

    protected $casts = [
        'rating' => 'integer',
        'approved' => 'boolean'
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function approvedListings()
    {
        return $this->hasMany(Listing::class)->where('status', 'approved');
    }
}
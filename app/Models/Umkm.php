<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'business_name', 'slug', 'description', 
        'address', 'phone', 'latitude', 'longitude', 'status', 'photo',
        'operating_hours', 'admin_note', 'geo_verified_at'
    ];

    protected $appends = ['avg_rating'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($umkm) {
            if (empty($umkm->slug)) {
                $umkm->slug = \Illuminate\Support\Str::slug($umkm->name) . '-' . uniqid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function beverages()
    {
        return $this->hasMany(ProductBeverage::class);
    }

    public function roasteries()
    {
        return $this->hasMany(ProductRoastery::class);
    }

    public function beans()
    {
        return $this->hasMany(ProductBean::class);
    }

    /**
     * Get all products for this UMKM from all 3 tables.
     */
    public function getAllProducts()
    {
        return collect()
            ->merge($this->beverages)
            ->merge($this->roasteries)
            ->merge($this->beans)
            ->sortByDesc('created_at');
    }

    public function verificationDocuments()
    {
        return $this->hasMany(VerificationDocument::class);
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function getAvgRatingAttribute()
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }
}

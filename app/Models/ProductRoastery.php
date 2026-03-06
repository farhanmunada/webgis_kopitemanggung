<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductRoastery extends Model
{
    protected $appends = ['type'];

    public function getTypeAttribute()
    {
        return 'roastery';
    }

    protected $fillable = [
        'umkm_id', 'name', 'slug', 'service_type', 'variety', 
        'origin', 'process', 'roast_level', 'weight_gram', 
        'grind_size', 'min_order_kg', 'price', 
        'stock', 'photo', 'description', 'status', 'rejected_reason', 'views'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'min_order_kg' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . uniqid();
            }
        });
    }

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }
}

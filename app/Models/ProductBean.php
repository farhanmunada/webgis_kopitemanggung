<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductBean extends Model
{
    protected $appends = ['type'];

    public function getTypeAttribute()
    {
        return 'bean';
    }

    protected $fillable = [
        'umkm_id', 'name', 'slug', 'bean_status', 'variety', 
        'origin', 'process', 'roast_level', 'grind_size', 
        'weight_gram', 'altitude_masl', 'price', 
        'stock', 'photo', 'description', 'status', 'rejected_reason', 'views'
    ];

    protected $casts = [
        'price' => 'decimal:2',
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

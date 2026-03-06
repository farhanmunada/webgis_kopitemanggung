<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductBeverage extends Model
{
    protected $appends = ['type'];

    public function getTypeAttribute()
    {
        return 'beverage';
    }

    protected $fillable = [
        'umkm_id', 'name', 'slug', 'drink_type', 'temperature', 
        'size_options', 'is_customizable', 'price', 
        'stock', 'photo', 'description', 'status', 'rejected_reason', 'views'
    ];

    protected $casts = [
        'is_customizable' => 'boolean',
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

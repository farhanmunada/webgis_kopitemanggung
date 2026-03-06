<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'color'];

    public function umkms()
    {
        return $this->hasMany(Umkm::class);
    }
}

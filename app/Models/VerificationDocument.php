<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Umkm;

class VerificationDocument extends Model
{
    protected $fillable = [
        'umkm_id', 'type', 'file_path', 'verified_by', 'verified_at'
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }
}

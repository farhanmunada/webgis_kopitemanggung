<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Umkm::with('category')->where('status', 'approved');
        
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        $umkms = $query->get(['id', 'category_id', 'business_name', 'slug', 'address', 'latitude', 'longitude', 'photo']);
        
        return response()->json($umkms);
    }
}

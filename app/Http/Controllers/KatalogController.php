<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index()
    {
        // For landing page, fetch latest approved products from all 3 tables
        $beverages = \App\Models\ProductBeverage::with(['umkm.category'])->where('status', 'approved')->latest()->take(4)->get();
        $roasteries = \App\Models\ProductRoastery::with(['umkm.category'])->where('status', 'approved')->latest()->take(4)->get();
        $beans = \App\Models\ProductBean::with(['umkm.category'])->where('status', 'approved')->latest()->take(4)->get();

        $products = collect()
            ->merge($beverages)
            ->merge($roasteries)
            ->merge($beans)
            ->sortByDesc('created_at')
            ->take(8);
            
        return view('katalog.index', compact('products'));
    }

    public function showUmkm($slug)
    {
        $umkm = \App\Models\Umkm::with(['category'])
            ->where('slug', $slug)
            ->firstOrFail();
            
        $products = $umkm->getAllProducts()->where('status', 'approved');
            
        return view('katalog.show_umkm', compact('umkm', 'products'));
    }

    public function showProduct($type, $slug)
    {
        $model = $this->getModelByType($type);
        $product = $model::with(['umkm.category', 'umkm.reviews.user'])
            ->where('slug', $slug)
            ->firstOrFail();
            
        // Increment views
        $product->increment('views');
        
        // Related products (same category, excluding current)
        $relatedProducts = $model::where('umkm_id', $product->umkm_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'approved')
            ->take(4)
            ->get();
            
        $reviews = $product->umkm->reviews()->latest()->get();
            
        return view('katalog.show_product', compact('product', 'type', 'relatedProducts', 'reviews'));
    }

    public function storeReview(Request $request, $type, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $model = $this->getModelByType($type);
        $product = $model::findOrFail($id);

        \App\Models\Review::create([
            'user_id' => auth()->id(),
            'reviewable_id' => $product->umkm_id,
            'reviewable_type' => \App\Models\Umkm::class,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Ulasan Anda berhasil dikirim! Terima kasih atas dukungannya.');
    }

    private function getModelByType($type)
    {
        return match ($type) {
            'beverage' => \App\Models\ProductBeverage::class,
            'roastery' => \App\Models\ProductRoastery::class,
            'bean' => \App\Models\ProductBean::class,
            default => abort(404),
        };
    }
}

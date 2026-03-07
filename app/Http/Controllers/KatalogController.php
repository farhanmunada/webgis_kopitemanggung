<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function umkmIndex()
    {
        // Best UMKM based on rating (min 1 review)
        $bestUmkms = \App\Models\Umkm::with(['category', 'reviews'])
            ->where('status', 'approved')
            ->get()
            ->sortByDesc('avg_rating')
            ->take(4);

        // Grouped by categories
        $coffeeshopUmkms = \App\Models\Umkm::with(['category', 'reviews'])
            ->where('status', 'approved')
            ->whereHas('category', function($q) { $q->where('name', 'Coffee Shop'); })
            ->get();

        $roasteryUmkms = \App\Models\Umkm::with(['category', 'reviews'])
            ->where('status', 'approved')
            ->whereHas('category', function($q) { $q->where('name', 'Roastery'); })
            ->get();

        $supplierUmkms = \App\Models\Umkm::with(['category', 'reviews'])
            ->where('status', 'approved')
            ->whereHas('category', function($q) { $q->where('name', 'Toko Kopi'); })
            ->get();

        return view('umkm.index', compact('bestUmkms', 'coffeeshopUmkms', 'roasteryUmkms', 'supplierUmkms'));
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        // Base queries
        $beverageQuery = \App\Models\ProductBeverage::with(['umkm.category'])->where('status', 'approved');
        $roasteryQuery = \App\Models\ProductRoastery::with(['umkm.category'])->where('status', 'approved');
        $beanQuery = \App\Models\ProductBean::with(['umkm.category'])->where('status', 'approved');

        if ($search) {
            $searchCallback = function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('umkm', function ($q) use ($search) {
                        $q->where('business_name', 'like', "%{$search}%")
                          ->orWhereHas('category', function ($qc) use ($search) {
                              $qc->where('name', 'like', "%{$search}%");
                          });
                    });
            };

            $beverageQuery->where(function($query) use ($search, $searchCallback) {
                $searchCallback($query);
                $query->orWhere('drink_type', 'like', "%{$search}%");
            });

            $roasteryQuery->where(function($query) use ($search, $searchCallback) {
                $searchCallback($query);
                $query->orWhere('variety', 'like', "%{$search}%")
                      ->orWhere('process', 'like', "%{$search}%");
            });

            $beanQuery->where(function($query) use ($search, $searchCallback) {
                $searchCallback($query);
                $query->orWhere('variety', 'like', "%{$search}%")
                      ->orWhere('process', 'like', "%{$search}%")
                      ->orWhere('origin', 'like', "%{$search}%");
            });
        }

        // Fetch all results for sections
        $coffeeshopProducts = $beverageQuery->latest()->get();
        $roasteryProducts = $roasteryQuery->latest()->get();
        $supplierProducts = $beanQuery->latest()->get();

        // Recommended: High view count from all types
        $recommendedProducts = collect()
            ->merge(\App\Models\ProductBeverage::where('status', 'approved')->orderBy('views', 'desc')->take(4)->get())
            ->merge(\App\Models\ProductRoastery::where('status', 'approved')->orderBy('views', 'desc')->take(2)->get())
            ->merge(\App\Models\ProductBean::where('status', 'approved')->orderBy('views', 'desc')->take(2)->get())
            ->sortByDesc('views')
            ->take(8);

        // Latest: Just arrival
        $latestProducts = collect()
            ->merge(\App\Models\ProductBeverage::where('status', 'approved')->latest()->take(3)->get())
            ->merge(\App\Models\ProductRoastery::where('status', 'approved')->latest()->take(3)->get())
            ->merge(\App\Models\ProductBean::where('status', 'approved')->latest()->take(2)->get())
            ->sortByDesc('created_at')
            ->take(8);

        // For search results specifically
        $searchResults = collect();
        if ($search) {
            $searchResults = collect()
                ->merge($coffeeshopProducts)
                ->merge($roasteryProducts)
                ->merge($supplierProducts)
                ->sortByDesc('created_at');
        }

        return view('katalog.index', compact(
            'latestProducts', 
            'recommendedProducts', 
            'coffeeshopProducts', 
            'roasteryProducts', 
            'supplierProducts',
            'searchResults',
            'search'
        ));
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

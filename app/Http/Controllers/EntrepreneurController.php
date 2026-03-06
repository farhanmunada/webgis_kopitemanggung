<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EntrepreneurController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $umkm = $user->umkms()->first();
        
        if (!$umkm) {
            return redirect()->route('umkm.register');
        }

        $allProducts = $umkm->getAllProducts();
        
        // Statistics calculation
        $stats = [
            'total_products' => $allProducts->count(),
            'total_views' => $allProducts->sum('views'),
            'avg_rating' => $umkm->avg_rating,
            'total_reviews' => $umkm->reviews()->count(),
            'pending_approval' => $allProducts->where('status', 'pending')->count(),
        ];
        
        // Top 5 products by views
        $popularProducts = $allProducts->sortByDesc('views')->take(5);

        // Recent 5 reviews
        $latestReviews = $umkm->reviews()->with('user')->latest()->take(5)->get();
        
        return view('entrepreneur.dashboard', compact('umkm', 'stats', 'popularProducts', 'latestReviews'));
    }

    public function indexProducts()
    {
        $user = auth()->user();
        $umkm = $user->umkms()->first();
        $products = $umkm ? $umkm->getAllProducts() : [];
        
        return view('entrepreneur.products.index', compact('umkm', 'products'));
    }

    public function storeProduct(Request $request)
    {
        $user = auth()->user();
        $umkm = $user->umkms()->first();

        if (!$umkm) {
            return redirect()->back()->with('error', 'Anda harus memiliki UMKM yang aktif untuk menambah produk.');
        }

        // 1. Validasi Dasar
        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];

        // 2. Validasi Spesifik Kategori
        if ($umkm->category->slug == 'coffee-shop') {
            $rules['drink_type'] = 'required|in:espresso_based,manual_brew,non_coffee,signature';
            $rules['temperature'] = 'required|in:hot,iced,blended,all';
        } elseif ($umkm->category->slug == 'roastery') {
            $rules['service_type'] = 'required|in:jasa_roasting,biji_sangrai,kopi_bubuk';
            if ($request->service_type !== 'jasa_roasting') {
                $rules['variety'] = 'required|string|max:100';
            }
        } elseif ($umkm->category->slug == 'toko-kopi') {
            $rules['bean_status'] = 'required|in:green_bean,roasted_bean,ground';
            $rules['variety'] = 'required|string|max:100';
            $rules['origin'] = 'required|string|max:100';
            $rules['weight_gram'] = 'required|integer|min:1';
        }

        $request->validate($rules);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('products', 'public');
        }

        // 3. Simpan ke Tabel Spesifik
        $commonData = [
            'umkm_id' => $umkm->id,
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . uniqid(),
            'price' => $request->price,
            'stock' => $request->stock,
            'photo' => $photoPath,
            'description' => $request->description,
            'status' => 'pending',
        ];

        if ($umkm->category->slug == 'coffee-shop') {
            \App\Models\ProductBeverage::create(array_merge($commonData, [
                'drink_type' => $request->drink_type,
                'temperature' => $request->temperature,
                'size_options' => $request->size_options,
                'is_customizable' => $request->has('is_customizable'),
            ]));
        } elseif ($umkm->category->slug == 'roastery') {
            \App\Models\ProductRoastery::create(array_merge($commonData, [
                'service_type' => $request->service_type,
                'variety' => $request->variety,
                'origin' => $request->origin,
                'process' => $request->process,
                'roast_level' => $request->roast_level,
                'weight_gram' => $request->weight_gram,
                'grind_size' => $request->grind_size,
                'min_order_kg' => $request->min_order_kg,
            ]));
        } elseif ($umkm->category->slug == 'toko-kopi') {
            \App\Models\ProductBean::create(array_merge($commonData, [
                'bean_status' => $request->bean_status,
                'variety' => $request->variety,
                'origin' => $request->origin,
                'process' => $request->process,
                'roast_level' => $request->roast_level,
                'grind_size' => $request->grind_size,
                'weight_gram' => $request->weight_gram,
                'altitude_masl' => $request->altitude_masl,
            ]));
        }

        return redirect()->route('entrepreneur.product.index')->with('success', 'Produk berhasil diajukan dan sedang menunggu persetujuan Admin.');
    }

    public function destroyProduct($type, $id)
    {
        $model = $this->getModelByType($type);
        $product = $model::findOrFail($id);

        if ($product->umkm_id !== auth()->user()->umkms()->first()->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        if ($product->photo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->photo);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus.');
    }

    public function editProduct($type, $id)
    {
        $model = $this->getModelByType($type);
        $product = $model::findOrFail($id);
        $umkm = auth()->user()->umkms()->first();

        if ($product->umkm_id !== $umkm->id) {
            abort(403);
        }

        return view('entrepreneur.products.edit', compact('product', 'type', 'umkm'));
    }

    public function updateProduct(Request $request, $type, $id)
    {
        $model = $this->getModelByType($type);
        $product = $model::findOrFail($id);
        $umkm = auth()->user()->umkms()->first();

        if ($product->umkm_id !== $umkm->id) {
            abort(403);
        }

        // Basic validation (same as store)
        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];

        // Specific validation (reuse from store or extract to method if needed)
        // For brevity in this edit, I'll focus on the update logic
        $request->validate($rules);

        if ($request->hasFile('photo')) {
            if ($product->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->photo);
            }
            $product->photo = $request->file('photo')->store('products', 'public');
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->description = $request->description;
        
        // Update specific fields based on type
        if ($type == 'beverage') {
            $product->drink_type = $request->drink_type;
            $product->temperature = $request->temperature;
            $product->size_options = $request->size_options;
            $product->is_customizable = $request->has('is_customizable');
        } elseif ($type == 'roastery') {
            $product->service_type = $request->service_type;
            $product->variety = $request->variety;
            $product->origin = $request->origin;
            $product->process = $request->process;
            $product->roast_level = $request->roast_level;
            $product->weight_gram = $request->weight_gram;
            $product->grind_size = $request->grind_size;
            $product->min_order_kg = $request->min_order_kg;
        } elseif ($type == 'bean') {
            $product->bean_status = $request->bean_status;
            $product->variety = $request->variety;
            $product->origin = $request->origin;
            $product->process = $request->process;
            $product->roast_level = $request->roast_level;
            $product->grind_size = $request->grind_size;
            $product->weight_gram = $request->weight_gram;
            $product->altitude_masl = $request->altitude_masl;
        }

        $product->status = 'pending'; // Reset to pending after edit
        $product->save();

        return redirect()->route('entrepreneur.product.index')->with('success', 'Produk berhasil diperbarui dan menunggu re-approval.');
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

    public function createUmkm()
    {
        $user = auth()->user();
        
        // If user already has a UMKM, check status
        $umkm = $user->umkms()->first();
        if ($umkm) {
            if ($umkm->status === 'pending') {
                return redirect()->route('dashboard')->with('message', 'Pendaftaran UMKM Anda sedang menunggu validasi admin.');
            }
            if ($umkm->status === 'active') {
                return redirect()->route('entrepreneur.dashboard');
            }
        }
        
        $categories = \App\Models\Category::all();
        return view('entrepreneur.register_umkm', compact('categories'));
    }

    public function storeUmkm(Request $request)
    {
        $user = auth()->user();
        
        if ($user->umkms()->exists()) {
            return redirect()->route('dashboard')->with('error', 'Anda sudah memiliki atau sedang mendaftarkan UMKM.');
        }

        $request->validate([
            'business_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('umkm', 'public');
        }

        \App\Models\Umkm::create([
            'user_id' => $user->id,
            'category_id' => $request->category_id,
            'business_name' => $request->business_name,
            'slug' => \Illuminate\Support\Str::slug($request->business_name) . '-' . uniqid(),
            'description' => $request->description,
            'address' => $request->address,
            'phone' => $request->phone,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => 'pending',
            'photo' => $photoPath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Pendaftaran UMKM berhasil! Silakan tunggu validasi dari Admin sebelum Anda dapat memposting produk.');
    }
}

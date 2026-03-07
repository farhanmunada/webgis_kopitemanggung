<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;
use App\Models\AuditTrail;
use Illuminate\Support\Facades\Mail;
use App\Notifications\UMKMStatusChanged;
use App\Notifications\ProductStatusChanged;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingBeverages = \App\Models\ProductBeverage::where('status', 'pending');
        $pendingRoasteries = \App\Models\ProductRoastery::where('status', 'pending');
        $pendingBeans = \App\Models\ProductBean::where('status', 'pending');

        $stats = [
            'pendingSellers' => Umkm::where('status', 'pending')->count(),
            'pendingProducts' => $pendingBeverages->count() + $pendingRoasteries->count() + $pendingBeans->count(),
            'totalUsers' => \App\Models\User::count(),
            'totalUmkm' => Umkm::count(),
            'totalProducts' => \App\Models\ProductBeverage::count() + \App\Models\ProductRoastery::count() + \App\Models\ProductBean::count(),
            'categoryStats' => \App\Models\Category::withCount('umkms')->get(),
            'productStatusStats' => [
                'approved' => \App\Models\ProductBeverage::where('status', 'approved')->count() + \App\Models\ProductRoastery::where('status', 'approved')->count() + \App\Models\ProductBean::where('status', 'approved')->count(),
                'pending' => $pendingBeverages->count() + $pendingRoasteries->count() + $pendingBeans->count(),
                'rejected' => \App\Models\ProductBeverage::where('status', 'rejected')->count() + \App\Models\ProductRoastery::where('status', 'rejected')->count() + \App\Models\ProductBean::where('status', 'rejected')->count(),
            ],
            'recentProducts' => collect()
                ->merge($pendingBeverages->with('umkm')->latest()->take(5)->get()->map(fn($p) => array_merge($p->toArray(), ['type' => 'beverage', 'umkm' => $p->umkm])))
                ->merge($pendingRoasteries->with('umkm')->latest()->take(5)->get()->map(fn($p) => array_merge($p->toArray(), ['type' => 'roastery', 'umkm' => $p->umkm])))
                ->merge($pendingBeans->with('umkm')->latest()->take(5)->get()->map(fn($p) => array_merge($p->toArray(), ['type' => 'bean', 'umkm' => $p->umkm])))
                ->sortByDesc('created_at')->take(5)
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function productsIndex()
    {
        $allProducts = collect()
            ->merge(\App\Models\ProductBeverage::with('umkm')->latest()->get()->map(fn($p) => array_merge($p->toArray(), ['type' => 'beverage', 'umkm' => $p->umkm])))
            ->merge(\App\Models\ProductRoastery::with('umkm')->latest()->get()->map(fn($p) => array_merge($p->toArray(), ['type' => 'roastery', 'umkm' => $p->umkm])))
            ->merge(\App\Models\ProductBean::with('umkm')->latest()->get()->map(fn($p) => array_merge($p->toArray(), ['type' => 'bean', 'umkm' => $p->umkm])))
            ->sortByDesc('created_at');

        return view('admin.products.index', compact('allProducts'));
    }

    public function usersIndex()
    {
        $allUmkms = Umkm::with(['user', 'category'])
            ->latest()
            ->get();
            
        $allUsers = \App\Models\User::latest()->get();

        return view('admin.users.index', compact('allUmkms', 'allUsers'));
    }

    public function showUmkm($id)
    {
        $umkm = Umkm::with(['user', 'category', 'verificationDocuments', 'reviews.user'])->findOrFail($id);
        $auditTrails = AuditTrail::where('auditable_type', Umkm::class)
            ->where('auditable_id', $umkm->id)
            ->latest()
            ->get();
            
        return view('admin.umkms.show', compact('umkm', 'auditTrails'));
    }

    public function showProduct($type, $id)
    {
        $model = $this->getModelByType($type);
        $product = $model::with(['umkm.category', 'umkm.user'])->findOrFail($id);
        
        $auditTrails = AuditTrail::where('auditable_type', get_class($product))
            ->where('auditable_id', $product->id)
            ->latest()
            ->get();

        return view('admin.products.show', compact('product', 'type', 'auditTrails'));
    }

    public function approveUmkm($id)
    {
        $umkm = Umkm::findOrFail($id);
        
        \Illuminate\Support\Facades\DB::transaction(function () use ($umkm) {
            $umkm->update(['status' => 'approved']);
            
            // Upgrade user role to umkm
            $user = $umkm->user;
            if ($user->role === 'public') {
                $user->update(['role' => 'umkm']);
            }
        });

        AuditTrail::create([
            'user_id' => auth()->id(),
            'action' => 'Approved UMKM',
            'auditable_type' => Umkm::class,
            'auditable_id' => $umkm->id,
            'notes' => 'UMKM ' . $umkm->business_name . ' disetujui. Role user diupgrade ke Pengusaha (umkm).',
        ]);

        // Notify User
        $umkm->user->notify(new UMKMStatusChanged($umkm, 'approved'));

        return redirect()->back()->with('success', 'UMKM ' . $umkm->business_name . ' telah disetujui dan user resmi menjadi Pengusaha.');
    }

    public function rejectUmkm(Request $request, $id)
    {
        $umkm = Umkm::findOrFail($id);
        $umkm->update([
            'status' => 'rejected',
            'admin_note' => $request->rejected_reason
        ]);

        AuditTrail::create([
            'user_id' => auth()->id(),
            'action' => 'Rejected UMKM',
            'auditable_type' => Umkm::class,
            'auditable_id' => $umkm->id,
            'notes' => 'UMKM ' . $umkm->business_name . ' ditolak: ' . $request->rejected_reason,
        ]);

        // Notify User
        $umkm->user->notify(new UMKMStatusChanged($umkm, 'rejected', $request->rejected_reason));

        return redirect()->back()->with('success', 'UMKM ' . $umkm->business_name . ' telah ditolak.');
    }

    public function approveProduct($type, $id)
    {
        $model = $this->getModelByType($type);
        $product = $model::findOrFail($id);
        $product->update(['status' => 'approved']);

        AuditTrail::create([
            'user_id' => auth()->id(),
            'action' => 'Approved Product',
            'auditable_type' => get_class($product),
            'auditable_id' => $product->id,
            'notes' => 'Produk ' . $product->name . ' (' . $type . ') disetujui.',
        ]);

        // Notify User
        $product->umkm->user->notify(new ProductStatusChanged($product, 'approved'));

        return redirect()->back()->with('success', 'Produk ' . $product->name . ' telah disetujui.');
    }

    public function rejectProduct(Request $request, $type, $id)
    {
        $model = $this->getModelByType($type);
        $product = $model::findOrFail($id);
        $product->update([
            'status' => 'rejected',
            'rejected_reason' => $request->rejected_reason
        ]);

        AuditTrail::create([
            'user_id' => auth()->id(),
            'action' => 'Rejected Product',
            'auditable_type' => get_class($product),
            'auditable_id' => $product->id,
            'notes' => 'Produk ' . $product->name . ' (' . $type . ') ditolak: ' . $request->rejected_reason,
        ]);

        // Notify User
        $product->umkm->user->notify(new ProductStatusChanged($product, 'rejected', $request->rejected_reason));

        return redirect()->back()->with('success', 'Produk ' . $product->name . ' telah ditolak.');
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

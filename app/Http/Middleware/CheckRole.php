<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check() || auth()->user()->role !== $role) {
            if ($request->wantsJson()) {
                abort(403, 'Akses Ditolak.');
            }
            
            // Redirect based on actual role or to home if no access
            if (auth()->check()) {
                if (auth()->user()->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                } elseif (auth()->user()->role === 'umkm') {
                    return redirect()->route('entrepreneur.dashboard');
                }
            }
            
            return redirect('/')->with('message', 'Akun Anda sedang menunggu validasi admin atau tidak memiliki akses.');
        }

        return $next($request);
    }
}

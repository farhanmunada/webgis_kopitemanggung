<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('/favicon-96x96.png') }}" sizes="96x96" />
        <link rel="icon" type="image/svg+xml" href="{{ asset('/favicon.svg') }}" />
        <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/apple-touch-icon.png') }}" />
        <meta name="apple-mobile-web-app-title" content="WebGIS" />
        <link rel="manifest" href="{{ asset('/site.webmanifest') }}" />
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @if(request()->routeIs('map.*') || request()->routeIs('dashboard') || request()->routeIs('admin.*') || request()->routeIs('product.show') || request()->routeIs('katalog.umkm') || request()->routeIs('entrepreneur.*'))
                <!-- Hide default navigation if we use custom sidebars or no-nav layouts -->
            @else
                @include('layouts.navigation')
            @endif

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        
        @stack('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        @if(Auth::check() && Auth::user()->role === 'public' && Auth::user()->umkms()->exists())
            @php 
                $umkm = Auth::user()->umkms()->latest()->first();
                $shouldShow = session('show_umkm_status') || !session('umkm_status_notified');
            @endphp

            @if($shouldShow)
                @php session(['umkm_status_notified' => true]); @endphp
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const status = "{{ $umkm->status }}";
                        const businessName = "{{ $umkm->business_name }}";
                        const adminNote = "{{ $umkm->admin_note ?? '' }}";

                        if (status === 'pending') {
                            Swal.fire({
                                icon: 'info',
                                title: '<span class="font-black text-2xl uppercase tracking-tight">Pendaftaran Diproses</span>',
                                html: `<div class="font-medium text-gray-600 leading-relaxed mt-2 text-sm">Hai <b>{{ Auth::user()->name }}</b>, pendaftaran UMKM <b>${businessName}</b> sedang dalam tahap verifikasi oleh Admin. <br><br>Mohon tunggu informasi selanjutnya.</div>`,
                                confirmButtonText: 'Sipp, Saya Tunggu',
                                confirmButtonColor: '#ea580c',
                                border: 'none',
                                borderRadius: '32px',
                                customClass: {
                                    popup: 'rounded-[32px] p-8',
                                    confirmButton: 'rounded-2xl px-8 py-3 font-black uppercase text-xs tracking-widest'
                                }
                            });
                        } else if (status === 'rejected') {
                            Swal.fire({
                                icon: 'error',
                                title: '<span class="font-black text-2xl uppercase tracking-tight text-red-600">Pendaftaran Ditolak</span>',
                                html: `<div class="font-medium text-gray-600 leading-relaxed mt-2 text-sm text-center">Mohon maaf, pendaftaran <b>${businessName}</b> belum dapat kami setujui.<br><br><div class="p-4 bg-red-50 rounded-2xl border border-red-100 text-red-700 italic font-bold">"${adminNote}"</div></div>`,
                                confirmButtonText: 'Mengerti',
                                confirmButtonColor: '#991b1b',
                                customClass: {
                                    popup: 'rounded-[32px] p-8',
                                    confirmButton: 'rounded-2xl px-8 py-3 font-black uppercase text-xs tracking-widest'
                                }
                            });
                        }
                    });
                </script>
            @endif
        @endif
    </body>
</html>

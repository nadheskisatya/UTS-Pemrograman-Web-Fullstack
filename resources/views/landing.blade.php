@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-[100svh]">

    {{-- Navbar --}}
    <nav class="flex items-center justify-between px-10 py-5 border-b border-kopi-border">
        <span class="text-gold font-semibold tracking-widest text-sm uppercase"
              style="font-family:'Montserrat',sans-serif">
            POS Kopi
        </span>
        <div class="flex gap-4">
            <a href="{{ route('kasir.index') }}"
               class="px-5 py-2 border border-kopi-gold text-kopi-gold text-sm tracking-wider
                      hover:bg-kopi-gold hover:text-kopi-black transition-all duration-200"
               style="font-family:'Montserrat',sans-serif">
                Login Kasir
            </a>
            <a href="{{ route('admin.dashboard') }}"
               class="px-5 py-2 bg-kopi-gold text-kopi-black text-sm tracking-wider
                      hover:bg-kopi-gold-lt transition-all duration-200 font-medium"
               style="font-family:'Montserrat',sans-serif">
                Login Admin
            </a>
        </div>
    </nav>

    {{-- Hero — 100svh total termasuk navbar & footer --}}
    <section class="flex-1 flex items-center justify-center px-16 gap-16">

        {{-- Kiri: Logo / Ikon Kopi --}}
        <div class="flex-shrink-0 flex items-center justify-center w-64 h-64">
            <svg viewBox="0 0 120 120" class="w-48 h-48 opacity-90" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Cangkir kopi sederhana -->
                <rect x="20" y="55" width="70" height="45" rx="8" fill="#c9a84c" opacity="0.15" stroke="#c9a84c" stroke-width="1.5"/>
                <path d="M90 65 Q110 65 110 78 Q110 90 90 90" stroke="#c9a84c" stroke-width="1.5" fill="none"/>
                <ellipse cx="55" cy="55" rx="35" ry="8" fill="#c9a84c" opacity="0.3" stroke="#c9a84c" stroke-width="1"/>
                <!-- Uap asap -->
                <path d="M40 48 Q38 38 42 30 Q46 22 44 14" stroke="#c9a84c" stroke-width="1" fill="none" stroke-linecap="round" opacity="0.5"/>
                <path d="M55 46 Q53 36 57 28 Q61 20 59 12" stroke="#c9a84c" stroke-width="1" fill="none" stroke-linecap="round" opacity="0.5"/>
                <path d="M70 48 Q68 38 72 30 Q76 22 74 14" stroke="#c9a84c" stroke-width="1" fill="none" stroke-linecap="round" opacity="0.5"/>
            </svg>
        </div>

        {{-- Kanan: Teks penjelasan --}}
        <div class="max-w-md">
            <h1 class="text-5xl font-light text-kopi-white leading-tight mb-4"
                style="letter-spacing:0.02em">
                Sistem Penjualan<br>
                <span class="text-gold">Biji Kopi</span>
            </h1>
            <p class="text-kopi-muted text-base leading-relaxed mb-8"
               style="font-family:'Montserrat',sans-serif; font-weight:300">
                Platform point-of-sale untuk pengelolaan transaksi, produk, dan laporan
                penjualan biji kopi secara efisien dan elegan.
            </p>
            <div class="w-16 h-px bg-kopi-gold opacity-60"></div>
        </div>

    </section>

    {{-- Footer --}}
    <footer class="px-10 py-5 border-t border-kopi-border flex items-center justify-between">
        <span class="text-kopi-muted text-xs" style="font-family:'Montserrat',sans-serif">
            &copy; {{ date('Y') }} POS Kopi
        </span>
        <span class="text-kopi-muted text-xs" style="font-family:'Montserrat',sans-serif">
            Sistem Manajemen Penjualan
        </span>
    </footer>

</div>
@endsection

@extends('layouts.kasir')
@vite('resources/js/kasir.js')
@section('content')
<div class="flex flex-col h-screen">

    {{-- Navbar Kasir --}}
    <nav class="flex items-center justify-between px-8 py-4 border-b border-kopi-border flex-shrink-0">
        <span class="text-gold tracking-widest text-sm uppercase" style="font-family:'Montserrat',sans-serif">
            Kasir — POS Kopi
        </span>
        <a href="{{ route('kasir.logout') }}"
           class="px-4 py-2 border border-kopi-border text-kopi-muted text-sm hover:border-kopi-gold hover:text-kopi-gold transition-all"
           style="font-family:'Montserrat',sans-serif">
            Logout
        </a>
    </nav>

    <div class="flex flex-1 overflow-hidden">

        {{-- Panel Kiri: Produk Grid --}}
        <div class="flex-1 overflow-y-auto p-6">
            <h2 class="text-kopi-muted text-xs uppercase tracking-widest mb-4" style="font-family:'Montserrat',sans-serif">
                Pilih Produk
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($produk as $item)
                <button onclick="addToCart({{ $item->id_produk }}, '{{ addslashes($item->nama_produk) }}', {{ $item->harga_produk }})"
                        class="bg-kopi-card border border-kopi-border p-4 text-left hover:border-kopi-gold hover:bg-kopi-surface transition-all duration-200 group">
                    <div class="w-full h-16 flex items-center justify-center mb-3 opacity-40 group-hover:opacity-70 transition-opacity">
                        <svg viewBox="0 0 40 40" class="w-10 h-10" fill="none">
                            <circle cx="20" cy="20" r="12" stroke="#c9a84c" stroke-width="1"/>
                            <circle cx="20" cy="20" r="6" fill="#c9a84c" opacity="0.3"/>
                        </svg>
                    </div>
                    <p class="text-kopi-white text-sm font-medium leading-tight mb-1">{{ $item->nama_produk }}</p>
                    <p class="text-gold text-xs" style="font-family:'Montserrat',sans-serif">
                        Rp {{ number_format($item->harga_produk, 0, ',', '.') }}
                    </p>
                    <p class="text-kopi-muted text-xs mt-1">{{ $item->kategori->jenis_biji ?? '-' }}</p>
                </button>
                @endforeach
            </div>
        </div>

        {{-- Panel Kanan: Cart --}}
        <div class="w-80 border-l border-kopi-border flex flex-col bg-kopi-surface flex-shrink-0">

            <div class="p-5 border-b border-kopi-border flex items-center justify-between">
                <h2 class="text-kopi-white text-sm uppercase tracking-widest" style="font-family:'Montserrat',sans-serif">
                    Keranjang
                </h2>
                <button onclick="clearCart()" class="text-kopi-muted text-xs hover:text-kopi-danger transition-colors" style="font-family:'Montserrat',sans-serif">
                    Hapus Semua
                </button>
            </div>

            {{-- Cart Items --}}
            <div id="cart-items" class="flex-1 overflow-y-auto p-4 space-y-3">
                <p id="cart-empty" class="text-kopi-muted text-sm text-center mt-8" style="font-family:'Montserrat',sans-serif">
                    Belum ada item
                </p>
            </div>

            {{-- Cart Footer --}}
            <div class="p-5 border-t border-kopi-border space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-kopi-muted text-xs uppercase tracking-wider" style="font-family:'Montserrat',sans-serif">Subtotal</span>
                    <span id="subtotal" class="text-kopi-white font-medium" style="font-family:'Montserrat',sans-serif">Rp 0</span>
                </div>

                <div>
                    <label class="text-kopi-muted text-xs uppercase tracking-wider block mb-2" style="font-family:'Montserrat',sans-serif">
                        Uang Pelanggan
                    </label>
                    <input type="number" id="uang-pelanggan" oninput="hitungKembalian()" placeholder="0"
                           class="w-full bg-kopi-card border border-kopi-border text-kopi-white px-3 py-2 focus:outline-none focus:border-kopi-gold text-sm"
                           style="font-family:'Montserrat',sans-serif">
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-kopi-muted text-xs uppercase tracking-wider" style="font-family:'Montserrat',sans-serif">Kembalian</span>
                    <span id="kembalian" class="text-gold font-medium" style="font-family:'Montserrat',sans-serif">Rp 0</span>
                </div>

                <button onclick="selesaiTransaksi()" class="w-full py-3 bg-kopi-gold text-kopi-black text-sm font-medium tracking-widest uppercase hover:bg-kopi-gold-lt transition-all duration-200" style="font-family:'Montserrat',sans-serif">
                    Selesai
                </button>
            </div>
        </div>

    </div>
</div>

{{-- Modal Nota --}}
<div id="modal-nota" class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 hidden">
    <div class="bg-kopi-card border border-kopi-border w-96 max-h-[90vh] overflow-y-auto p-8">

        <div class="text-center border-b border-kopi-border pb-5 mb-5">
            <p class="text-gold text-xs tracking-widest uppercase mb-1" style="font-family:'Montserrat',sans-serif">POS Kopi</p>
            <h3 class="text-kopi-white text-xl font-light">Nota Transaksi</h3>
            <p id="nota-waktu" class="text-kopi-muted text-xs mt-1" style="font-family:'Montserrat',sans-serif"></p>
        </div>

        <div id="nota-items" class="space-y-2 mb-5 text-sm"></div>

        <div class="border-t border-kopi-border pt-4 space-y-2">
            <div class="flex justify-between text-sm">
                <span class="text-kopi-muted" style="font-family:'Montserrat',sans-serif">Total</span>
                <span id="nota-total" class="text-kopi-white" style="font-family:'Montserrat',sans-serif"></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-kopi-muted" style="font-family:'Montserrat',sans-serif">Bayar</span>
                <span id="nota-bayar" class="text-kopi-white" style="font-family:'Montserrat',sans-serif"></span>
            </div>
            <div class="flex justify-between text-sm font-medium">
                <span class="text-gold" style="font-family:'Montserrat',sans-serif">Kembalian</span>
                <span id="nota-kembalian" class="text-gold" style="font-family:'Montserrat',sans-serif"></span>
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <button onclick="window.print()" class="flex-1 py-2 border border-kopi-border text-kopi-muted text-sm hover:border-kopi-gold hover:text-kopi-gold transition-all" style="font-family:'Montserrat',sans-serif">
                Cetak Nota
            </button>
            <button onclick="tutupNota()" class="flex-1 py-2 bg-kopi-gold text-kopi-black text-sm font-medium hover:bg-kopi-gold-lt transition-all" style="font-family:'Montserrat',sans-serif">
                Tutup
            </button>
        </div>

    </div>
</div>
@endsection

@extends('layouts.admin')
@section('title', 'Detail Produk')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.kategori.index') }}"
       class="text-kopi-muted text-xs hover:text-kopi-gold transition-colors"
       style="font-family:'Montserrat',sans-serif">
        ← Kembali
    </a>
</div>

<h1 class="text-2xl font-light text-kopi-white mb-8">Detail Kategori</h1>

<div class="bg-kopi-card border border-kopi-border p-6 max-w-lg">
    <div class="space-y-4">
        <div>
            <p class="text-kopi-muted text-xs uppercase tracking-wider mb-1"
               style="font-family:'Montserrat',sans-serif">ID Kategori</p>
            <p class="text-kopi-white">{{ $kategori->id_kategori }}</p>
        </div>
        <div>
            <p class="text-kopi-muted text-xs uppercase tracking-wider mb-1"
               style="font-family:'Montserrat',sans-serif">Jenis Biji</p>
            <p class="text-kopi-white text-xl">{{ $kategori->jenis_biji }}</p>
        </div>
    </div>

    <div class="flex gap-3 mt-8">
        <a href="{{ route('admin.produk.edit', $kategori->id_kategori) }}"
           class="px-4 py-2 border border-kopi-gold text-kopi-gold text-sm hover:bg-kopi-gold hover:text-kopi-black transition-all"
           style="font-family:'Montserrat',sans-serif">
            Edit
        </a>
    </div>
</div>
@endsection

@extends('layouts.admin')
@section('title', 'Edit Produk')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.produk.index') }}"
       class="text-kopi-muted text-xs hover:text-kopi-gold transition-colors"
       style="font-family:'Montserrat',sans-serif">← Kembali</a>
</div>

<h1 class="text-2xl font-light text-kopi-white mb-8">Edit Produk</h1>

<form action="{{ route('admin.produk.update', $produk->id_produk) }}" method="POST" class="max-w-lg space-y-5">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-kopi-muted text-xs uppercase tracking-wider mb-2"
               style="font-family:'Montserrat',sans-serif">Nama Produk</label>
        <input type="text" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}"
               class="w-full bg-kopi-card border border-kopi-border text-kopi-white px-4 py-3
                      focus:outline-none focus:border-kopi-gold transition-colors"
               style="font-family:'Montserrat',sans-serif">
        @error('nama_produk')
            <p class="text-kopi-danger text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-kopi-muted text-xs uppercase tracking-wider mb-2"
               style="font-family:'Montserrat',sans-serif">Harga</label>
        <input type="number" name="harga_produk" value="{{ old('harga_produk', $produk->harga_produk) }}" min="0"
               class="w-full bg-kopi-card border border-kopi-border text-kopi-white px-4 py-3
                      focus:outline-none focus:border-kopi-gold transition-colors"
               style="font-family:'Montserrat',sans-serif">
        @error('harga_produk')
            <p class="text-kopi-danger text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-kopi-muted text-xs uppercase tracking-wider mb-2"
               style="font-family:'Montserrat',sans-serif">Kategori</label>
        <select name="id_kategori"
                class="w-full bg-kopi-card border border-kopi-border text-kopi-white px-4 py-3
                       focus:outline-none focus:border-kopi-gold transition-colors"
                style="font-family:'Montserrat',sans-serif">
            @foreach($kategori as $kat)
            <option value="{{ $kat->id_kategori }}"
                {{ old('id_kategori', $produk->id_kategori) == $kat->id_kategori ? 'selected' : '' }}>
                {{ $kat->jenis_biji }}
            </option>
            @endforeach
        </select>
    </div>

    <button type="submit"
            class="px-6 py-3 bg-kopi-gold text-kopi-black text-sm font-medium hover:bg-kopi-gold-lt transition-all"
            style="font-family:'Montserrat',sans-serif">
        Perbarui Produk
    </button>
</form>
@endsection

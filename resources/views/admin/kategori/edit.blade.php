@extends('layouts.admin')
@section('title', 'Edit Kategori')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.kategori.index') }}" class="text-kopi-muted text-xs hover:text-kopi-gold transition-colors"
            style="font-family:'Montserrat',sans-serif">← Kembali</a>
    </div>

    <h1 class="text-2xl font-light text-kopi-white mb-8">Edit Kategori</h1>

    <form action="{{ route('admin.kategori.update', $kategori->id_kategori) }}" method="POST" class="max-w-lg space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-kopi-muted text-xs uppercase tracking-wider mb-2"
                style="font-family:'Montserrat',sans-serif">Nama Biji (Kategori)</label>
            <input type="text" name="jenis_biji" value="{{ old('jenis_biji', $kategori->jenis_biji) }}"
                class="w-full bg-kopi-card border border-kopi-border text-kopi-white px-4 py-3
                      focus:outline-none focus:border-kopi-gold transition-colors"
                style="font-family:'Montserrat',sans-serif">
            @error('jenis_biji')
                <p class="text-kopi-danger text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="px-6 py-3 bg-kopi-gold text-kopi-black text-sm font-medium hover:bg-kopi-gold-lt transition-all"
            style="font-family:'Montserrat',sans-serif">
            Perbarui Kategori
        </button>
    </form>
@endsection

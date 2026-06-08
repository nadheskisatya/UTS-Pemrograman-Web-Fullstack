@extends('layouts.admin')
@section('title', 'Kategori')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-2xl font-light text-kopi-white">Daftar Kategori</h1>
    <a href="{{ route('admin.kategori.create') }}"
       class="px-4 py-2 bg-kopi-gold text-kopi-black text-sm hover:bg-kopi-gold-lt transition-all"
       style="font-family:'Montserrat',sans-serif">
        + Tambah Kategori
    </a>
</div>

<div class="border border-kopi-border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-kopi-surface">
            <tr>
                <th class="text-left p-4 text-kopi-muted font-normal uppercase text-xs tracking-wider"
                    style="font-family:'Montserrat',sans-serif">#</th>
                <th class="text-left p-4 text-kopi-muted font-normal uppercase text-xs tracking-wider"
                    style="font-family:'Montserrat',sans-serif">Jenis Biji</th>
                <th class="text-left p-4 text-kopi-muted font-normal uppercase text-xs tracking-wider"
                    style="font-family:'Montserrat',sans-serif">Jumlah Produk</th>
                <th class="text-left p-4 text-kopi-muted font-normal uppercase text-xs tracking-wider"
                    style="font-family:'Montserrat',sans-serif">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategori as $item)
            <tr class="border-t border-kopi-border hover:bg-kopi-surface transition-colors">
                <td class="p-4 text-kopi-muted">{{ $loop->iteration }}</td>
                <td class="p-4 text-kopi-white">{{ $item->jenis_biji }}</td>
                <td class="p-4 text-kopi-muted">{{ $item->produk_count }}</td>
                <td class="p-4">
                    <div class="flex gap-3">
                        <a href="{{ route('admin.kategori.show', $item->id_kategori) }}"
                           class="text-kopi-muted text-xs hover:text-kopi-gold transition-colors"
                           style="font-family:'Montserrat',sans-serif">Detail</a>
                        <a href="{{ route('admin.kategori.edit', $item->id_kategori) }}"
                           class="text-kopi-muted text-xs hover:text-kopi-gold transition-colors"
                           style="font-family:'Montserrat',sans-serif">Edit</a>
                        <button onclick="hapusKategori({{ $item->id_kategori }})"
                                class="text-kopi-muted text-xs hover:text-kopi-danger transition-colors"
                                style="font-family:'Montserrat',sans-serif">Hapus</button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<form id="form-hapus-kategori" method="POST" style="display:none">
    @csrf @method('DELETE')
</form>
<script>
function hapusKategori(id) {
    if (!confirm('Yakin ingin menghapus kategori ini?')) return;
    const form = document.getElementById('form-hapus-kategori');
    form.action = '/admin/kategori/' + id;
    form.submit();
}
</script>
@endsection

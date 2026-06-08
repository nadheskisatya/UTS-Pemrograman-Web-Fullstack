@extends('layouts.admin')
@section('title', 'Produk')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-2xl font-light text-kopi-white">Daftar Produk</h1>
    <a href="{{ route('admin.produk.create') }}"
       class="px-4 py-2 bg-kopi-gold text-kopi-black text-sm hover:bg-kopi-gold-lt transition-all"
       style="font-family:'Montserrat',sans-serif">
        + Tambah Produk
    </a>
</div>

<div class="border border-kopi-border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-kopi-surface">
            <tr>
                <th class="text-left p-4 text-kopi-muted font-normal uppercase text-xs tracking-wider"
                    style="font-family:'Montserrat',sans-serif">#</th>
                <th class="text-left p-4 text-kopi-muted font-normal uppercase text-xs tracking-wider"
                    style="font-family:'Montserrat',sans-serif">Nama Produk</th>
                <th class="text-left p-4 text-kopi-muted font-normal uppercase text-xs tracking-wider"
                    style="font-family:'Montserrat',sans-serif">Harga</th>
                <th class="text-left p-4 text-kopi-muted font-normal uppercase text-xs tracking-wider"
                    style="font-family:'Montserrat',sans-serif">Kategori</th>
                <th class="text-left p-4 text-kopi-muted font-normal uppercase text-xs tracking-wider"
                    style="font-family:'Montserrat',sans-serif">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produk as $item)
            <tr class="border-t border-kopi-border hover:bg-kopi-surface transition-colors">
                <td class="p-4 text-kopi-muted">{{ $loop->iteration }}</td>
                <td class="p-4 text-kopi-white">{{ $item->nama_produk }}</td>
                <td class="p-4 text-gold" style="font-family:'Montserrat',sans-serif">
                    Rp {{ number_format($item->harga_produk, 0, ',', '.') }}
                </td>
                <td class="p-4 text-kopi-muted">{{ $item->kategori->jenis_biji ?? '—' }}</td>
                <td class="p-4">
                    <div class="flex gap-3">
                        <a href="{{ route('admin.produk.show', $item->id_produk) }}"
                           class="text-kopi-muted text-xs hover:text-kopi-gold transition-colors"
                           style="font-family:'Montserrat',sans-serif">Detail</a>
                        <a href="{{ route('admin.produk.edit', $item->id_produk) }}"
                           class="text-kopi-muted text-xs hover:text-kopi-gold transition-colors"
                           style="font-family:'Montserrat',sans-serif">Edit</a>
                        <button onclick="hapusProduk({{ $item->id_produk }})"
                                class="text-kopi-muted text-xs hover:text-kopi-danger transition-colors"
                                style="font-family:'Montserrat',sans-serif">Hapus</button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<form id="form-hapus-produk" method="POST" style="display:none">
    @csrf @method('DELETE')
</form>
<script>
function hapusProduk(id) {
    if (!confirm('Yakin ingin menghapus produk ini?')) return;
    const form = document.getElementById('form-hapus-produk');
    form.action = '/admin/produk/' + id;
    form.submit();
}
</script>
@endsection

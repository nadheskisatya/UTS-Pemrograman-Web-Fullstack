@extends('layouts.admin')
@section('title', 'Orders')

@section('content')
<h1 class="text-2xl font-light text-kopi-white mb-8">Semua Transaksi</h1>

@if($transaksi->isEmpty())
    <p class="text-kopi-muted" style="font-family:'Montserrat',sans-serif">
        Belum ada transaksi.
    </p>
@else
    <div class="space-y-4">
        @foreach($transaksi as $t)
        <div class="bg-kopi-card border border-kopi-border p-5">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <p class="text-kopi-white font-medium">
                        Transaksi #{{ $t->id_transaksi }}
                    </p>
                    <p class="text-kopi-muted text-xs mt-1"
                       style="font-family:'Montserrat',sans-serif">
                        {{ $t->created_at->format('d M Y, H:i') }}
                    </p>
                </div>
                <button onclick="hapusTransaksi({{ $t->id_transaksi }})"
                        class="text-kopi-muted text-xs hover:text-kopi-danger transition-colors"
                        style="font-family:'Montserrat',sans-serif">
                    Hapus
                </button>
            </div>

            <div class="space-y-1 mb-3">
                @foreach($t->detailTransaksi as $d)
                <div class="flex justify-between text-sm">
                    <span class="text-kopi-muted">
                        {{ $d->produk->nama_produk ?? '—' }} × {{ $d->quantity }}
                    </span>
                    <span class="text-kopi-white">
                        Rp {{ number_format($d->total_harga, 0, ',', '.') }}
                    </span>
                </div>
                @endforeach
            </div>

            <div class="border-t border-kopi-border pt-3 flex justify-between">
                <span class="text-kopi-muted text-sm" style="font-family:'Montserrat',sans-serif">
                    Total
                </span>
                <span class="text-gold font-medium">
                    Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                </span>
            </div>
        </div>
        @endforeach
    </div>
@endif

{{-- Form hapus tersembunyi --}}
<form id="form-hapus" method="POST" style="display:none">
    @csrf
    @method('DELETE')
</form>

<script>
function hapusTransaksi(id) {
    if (!confirm('Yakin ingin menghapus transaksi #' + id + '? Tindakan ini tidak bisa dibatalkan.')) return;
    const form = document.getElementById('form-hapus');
    form.action = '/admin/orders/' + id;
    form.submit();
}
</script>
@endsection

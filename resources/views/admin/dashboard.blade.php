@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<h1 class="text-2xl font-light text-kopi-white mb-2">Dashboard</h1>
<p class="text-kopi-muted text-sm mb-8" style="font-family:'Montserrat',sans-serif">
    Laporan penjualan harian
</p>

{{-- Total Hari Ini --}}
<div class="bg-kopi-card border border-kopi-border p-6 mb-8 inline-block">
    <p class="text-kopi-muted text-xs uppercase tracking-widest mb-2"
       style="font-family:'Montserrat',sans-serif">
        Total Penghasilan Hari Ini
    </p>
    <p class="text-3xl font-light text-gold">
        Rp {{ number_format($today, 0, ',', '.') }}
    </p>
</div>

{{-- 5 Hari Terakhir --}}
<h2 class="text-kopi-muted text-xs uppercase tracking-widest mb-4"
    style="font-family:'Montserrat',sans-serif">
    5 Hari Terakhir
</h2>

<div class="grid grid-cols-5 gap-4">
    @foreach($days as $day)
    <div class="bg-kopi-card border border-kopi-border p-5 text-center
                hover:border-kopi-gold transition-all duration-200">
        <p class="text-kopi-muted text-xs mb-3" style="font-family:'Montserrat',sans-serif">
            {{ $day['label'] }}
        </p>
        <p class="text-kopi-white font-light text-lg">
            Rp {{ number_format($day['total'], 0, ',', '.') }}
        </p>
    </div>
    @endforeach
</div>
@endsection

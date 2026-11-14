@extends('layouts.app')
@section('title', 'Produk & Layanan')
@section('content')
<h1 class="text-4xl font-bold text-blue-700 my-8">Produk & Jenis Layanan</h1>
@if (session('success'))
    <div class="bg-green-100 text-green-800 rounded-lg p-4 mb-6">{{ session('success') }}</div>
@endif
<p class="text-lg text-blue-900/90 max-w-3xl mb-8">
    {{ config('app.name') }} menyediakan layanan internet broadband, instalasi jaringan,
    dan maintenance untuk rumah, kantor, kafe, hingga skala bisnis.
</p>

<section class="grid gap-6 md:grid-cols-3 mb-12">
    <div class="bg-blue-100 p-6">
        <h2 class="text-xl font-bold text-blue-700 mb-2">Layanan Internet Broadband</h2>
        <p class="text-blue-900/90">Paket koneksi internet rumahan dan bisnis dengan kecepatan stabil, mulai dari kebutuhan harian hingga dedicated line.</p>
    </div>
    <div class="bg-blue-100 p-6">
        <h2 class="text-xl font-bold text-blue-700 mb-2">Instalasi Jaringan</h2>
        <p class="text-blue-900/90">Perancangan dan pemasangan kabel, router, switch, access point, serta konfigurasi jaringan LAN/Wi-Fi siap pakai.</p>
    </div>
    <div class="bg-blue-100 p-6">
        <h2 class="text-xl font-bold text-blue-700 mb-2">Maintenance</h2>
        <p class="text-blue-900/90">Perawatan berkala, penanganan gangguan, pemeriksaan perangkat, dan dukungan teknis agar jaringan tetap optimal.</p>
    </div>
</section>

<section>
    <h2 class="text-2xl font-bold text-blue-700 mb-6">Paket Layanan</h2>
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($products as $product)
            @include('partials.product-card', ['product' => $product])
        @empty
            <p>Belum ada layanan. Tambahkan lewat halaman admin.</p>
        @endforelse
    </div>
</section>
@endsection

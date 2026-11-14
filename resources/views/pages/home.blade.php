@extends('layouts.app')
@section('title', 'Beranda')
@section('content')
<section class="flex justify-center py-12">
    <div class="max-w-4xl text-center">
        <h1 class="text-5xl md:text-6xl font-black text-blue-700 leading-tight">Internet Cepat & Jaringan Andal untuk Bisnis Anda</h1>
        <p class="text-2xl mt-6 text-blue-900/90">Broadband, instalasi jaringan, dan maintenance rutin, ditangani teknisi berpengalaman dengan dukungan responsif.</p>
        <a href="{{ route('products') }}" class="inline-block mt-8 bg-blue-600 text-white font-bold px-8 py-3 hover:bg-blue-700">Selengkapnya</a>
    </div>

</section>

<section class="py-8">
    <h2 class="text-2xl font-bold text-blue-700 mb-6">Layanan Kami</h2>
    <div class="grid gap-6 md:grid-cols-3">
        @foreach ($products as $product)
            @include('partials.product-card', ['product' => $product])
        @endforeach
    </div>
</section>

<section class="py-8">
    <h2 class="text-2xl font-bold text-blue-700 mb-6">Info Terkini</h2>
    <div class="grid gap-5 md:grid-cols-2">
        @forelse ($articles as $article)
            @include('partials.article-card', ['article' => $article])
        @empty
            <p>Belum ada artikel.</p>
        @endforelse
    </div>
</section>
@endsection

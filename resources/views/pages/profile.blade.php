@extends('layouts.app')
@section('title', 'Profil')
@section('content')
<section class="py-10 max-w-3xl">
    <h1 class="text-4xl font-bold text-blue-700 mb-6">Tentang {{ config('app.name') }}</h1>
    <p class="text-lg leading-relaxed mb-4">{{ config('app.name') }} adalah penyedia layanan internet broadband dan solusi jaringan yang membantu rumah, kantor, dan bisnis tetap terhubung dengan koneksi stabil.</p>
    <p class="text-lg leading-relaxed mb-4">Layanan kami mencakup pemasangan jaringan LAN/Wi-Fi, konfigurasi perangkat, hingga maintenance rutin dengan respons teknis yang cepat.</p>
    <p class="text-lg leading-relaxed">Visi kami sederhana: koneksi yang andal harus terjangkau dan layanan yang mudah dihubungi.</p>
</section>
@endsection

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Beranda') - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: {
            fontFamily: { sans: ['Lato', 'system-ui', 'sans-serif'] },
            colors: { ink: '#4e4589', soft: '#7a7bc4', mint: '#a5f3fc', teal: '#6dd3e0' }
        } } }
    </script>
</head>
<body class="bg-white text-blue-900 font-sans min-h-screen flex flex-col">
@php
    $menu = [
        'home' => 'Beranda',
        'profile' => 'Profil',
        'products' => 'Produk & Layanan',
        'gallery' => 'Galeri',
        'contact' => 'Kontak',
    ];
    $active = fn (string $route): bool => request()->routeIs($route);
@endphp
<header class="max-w-6xl w-full mx-auto px-6 py-6 flex flex-wrap items-center justify-between gap-4">
    <a href="{{ route('home') }}" class="flex items-center gap-3 text-xl font-bold">
        <img src="{{ asset('image/logoInternetNusantara.jpg') }}" alt="Logo {{ config('app.name') }}" class="w-10 h-10 object-cover border-2 border-blue-600">
        {{ config('app.name') }}
    </a>
    <nav class="flex flex-wrap items-center gap-x-7 gap-y-2 text-lg">
        @foreach ($menu as $route => $label)
            <a href="{{ route($route) }}" class="{{ $active($route) ? 'text-blue-700' : 'hover:text-blue-700' }}">{{ $label }}</a>
        @endforeach
        @auth('web')
            <span class="text-blue-900/80">{{ auth('web')->user()->name }}</span>
            <a href="{{ route('order.history') }}" class="{{ $active('order.history') ? 'text-blue-700' : 'hover:text-blue-700' }}">Riwayat Pesanan</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="font-bold text-blue-700 hover:text-blue-900">Keluar</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="{{ $active('login') ? 'text-blue-700' : 'hover:text-blue-700' }}">Masuk</a>
            <a href="{{ route('register') }}" class="bg-blue-600 text-white font-bold px-5 py-1.5 hover:bg-blue-700">Daftar</a>
        @endauth
    </nav>
</header>

<main class="flex-1 max-w-6xl w-full mx-auto px-6 pb-16">
    @yield('content')
</main>

<footer class="mt-10">
    <div class="max-w-6xl mx-auto px-6 py-10 grid gap-8 md:grid-cols-4 text-sm">
        <div>
            <div class="text-lg font-bold mb-3">{{ config('app.name') }}</div>
            <p class="text-blue-900/80 max-w-xs">Layanan internet broadband, instalasi jaringan, dan maintenance untuk rumah, kantor, dan bisnis.</p>
        </div>
        <div>
            <div class="font-bold mb-3">Tentang</div>
            <ul class="space-y-1 text-blue-900/80">
                <li><a href="{{ route('profile') }}" class="hover:text-blue-700">Profil</a></li>
                <li><a href="{{ route('gallery') }}" class="hover:text-blue-700">Galeri</a></li>
            </ul>
        </div>
        <div>
            <div class="font-bold mb-3">Bantuan</div>
            <ul class="space-y-1 text-blue-900/80">
                <li><a href="{{ route('contact') }}" class="hover:text-blue-700">Hubungi Kami</a></li>
                <li><a href="{{ route('products') }}" class="hover:text-blue-700">Daftar Layanan</a></li>
            </ul>
        </div>
        <div>
            <div class="font-bold mb-3">Kontak & Media Sosial</div>
            <ul class="space-y-1 text-blue-900/80">
                <li><a href="https://www.google.com/maps?q=-6.5533214974429645,106.77456109092883" target="_blank" rel="noopener noreferrer" class="hover:text-blue-700">Google Maps</a></li>
                <li><a href="mailto:hafidzalfarizi1501@gmail.com" class="hover:text-blue-700">hafidzalfarizi1501@gmail.com</a></li>
                <li><a href="https://wa.me/{{ config('services.whatsapp.number') }}" target="_blank" rel="noopener noreferrer" class="hover:text-blue-700">WhatsApp: +{{ config('services.whatsapp.number') }}</a></li>
                <li><a href="https://www.instagram.com/Hafidzalfaa15/" target="_blank" rel="noopener noreferrer" class="hover:text-blue-700">Instagram: @Hafidzalfaa15</a></li>
            </ul>
        </div>
    </div>
    <div class="bg-blue-600 text-white text-center text-sm py-3 font-bold">&copy; {{ date('Y') }} {{ config('app.name') }}. Hak cipta dilindungi.</div>
</footer>
</body>
</html>

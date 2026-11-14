@extends('layouts.app')
@section('title', 'Kontak')
@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<section class="py-10">
    <h1 class="text-4xl font-bold text-blue-700 mb-6">Hubungi Kami</h1>
    <p class="text-lg mb-6">Ceritakan kebutuhan internet dan jaringan Anda, kami balas dalam 1 hari kerja.</p>

    <div class="grid gap-8 lg:grid-cols-2 items-start">
        <dl class="space-y-3 text-lg">
            <div>
                <dt class="text-blue-700 font-bold">WhatsApp</dt>
                <dd><a href="https://wa.me/{{ config('services.whatsapp.number') }}" target="_blank" rel="noopener noreferrer" class="hover:text-blue-700">+{{ config('services.whatsapp.number') }}</a></dd>
            </div>
            <div><dt class="text-blue-700 font-bold">Email</dt><dd>hafidzalfarizi1501@gmail.com</dd></div>
            <div><dt class="text-blue-700 font-bold">Alamat</dt><dd>Bogor, Jawa Barat</dd></div>
            <div><dt class="text-blue-700 font-bold">Jam kerja</dt><dd>Senin sampai Jumat, 09.00 sampai 17.00 WIB</dd></div>
            <div><dt class="text-blue-700 font-bold">Media sosial</dt><dd>instagram: Hafidzalfaa15</dd></div>
        </dl>

        <div>
            <h2 class="text-2xl font-bold text-blue-700 mb-3">Lokasi Kami</h2>
            <div id="contact-map" class="w-full h-96 overflow-hidden border-2 border-white/20"></div>
            <p class="mt-2 text-sm text-blue-900/75">Geser peta atau gunakan tombol +/- untuk melihat lokasi.</p>
        </div>
    </div>
</section>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const location = [-6.5533214974429645, 106.77456109092883];
        const map = L.map('contact-map').setView(location, 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        L.marker(location).addTo(map)
            .bindPopup('<b>PT Solusi Net Nusantara</b><br>Lokasi kantor kami')
            .openPopup();
    });
</script>
@endsection

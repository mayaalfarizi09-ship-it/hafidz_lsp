@extends('layouts.app')
@section('title', 'Galery')
@section('content')
<h1 class="text-4xl font-bold text-blue-700 my-8">Galery</h1>
<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
    @forelse ($galleries as $g)
        <div class="bg-blue-100 overflow-hidden">
            @if ($g->image)
                <img src="{{ asset('storage/' . $g->image) }}" alt="{{ $g->title }}" class="w-full h-52 object-cover">
            @else
                <div class="w-full h-52 bg-white/50 grid place-items-center text-5xl">&#127912;</div>
            @endif
            <div class="p-5">
                <h2 class="text-xl text-blue-700 font-bold">{{ $g->title }}</h2>
                <p class="mt-1">{{ $g->description }}</p>
            </div>
        </div>
    @empty <p>Belum ada dokumentasi. Tambahkan lewat halaman admin.</p> @endforelse
</div>
@endsection

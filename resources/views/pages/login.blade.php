@extends('layouts.app')
@section('title', 'Masuk')
@section('content')
<section class="py-12 max-w-md mx-auto w-full">
    <h1 class="text-4xl font-bold text-blue-700 mb-2">Masuk</h1>
    <p class="text-blue-900/80 mb-8">Masuk ke akun Anda untuk mengelola layanan Anda.</p>

    <form method="POST" action="{{ route('login.attempt') }}" class="space-y-5">
        @csrf
        <div>
            <label for="email" class="block font-bold mb-2">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full bg-blue-50 border border-blue-200 px-4 py-3 text-blue-900 placeholder-blue-300 focus:outline-none focus:border-blue-600 @error('email') border-red-400 @enderror"
                   placeholder="nama@email.com">
            @error('email')
                <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block font-bold mb-2">Password</label>
            <input id="password" type="password" name="password" required
                   class="w-full bg-blue-50 border border-blue-200 px-4 py-3 text-blue-900 placeholder-blue-300 focus:outline-none focus:border-blue-600 @error('password') border-red-400 @enderror"
                   placeholder="••••••••">
            @error('password')
                <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white font-bold px-6 py-3 hover:bg-blue-700">Masuk</button>
    </form>

    <p class="mt-6 text-blue-900/80">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-blue-700 font-bold hover:text-blue-900">Daftar di sini</a>
    </p>
</section>
@endsection

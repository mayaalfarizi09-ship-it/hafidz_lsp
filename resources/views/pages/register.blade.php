@extends('layouts.app')
@section('title', 'Daftar')
@section('content')
<section class="py-12 max-w-md mx-auto w-full">
    <h1 class="text-4xl font-bold text-blue-700 mb-2">Daftar Akun</h1>
    <p class="text-blue-900/80 mb-8">Buat akun untuk mulai menggunakan layanan kami.</p>

    <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
        @csrf
        <div>
            <label for="name" class="block font-bold mb-2">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="w-full bg-blue-50 border border-blue-200 px-4 py-3 text-blue-900 placeholder-blue-300 focus:outline-none focus:border-blue-600 @error('name') border-red-400 @enderror"
                   placeholder="Nama Anda">
            @error('name')
                <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block font-bold mb-2">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
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
                   placeholder="Minimal 8 karakter">
            @error('password')
                <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block font-bold mb-2">Ulangi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                   class="w-full bg-blue-50 border border-blue-200 px-4 py-3 text-blue-900 placeholder-blue-300 focus:outline-none focus:border-blue-600"
                   placeholder="••••••••">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white font-bold px-6 py-3 hover:bg-blue-700">Daftar</button>
    </form>

    <p class="mt-6 text-blue-900/80">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-blue-700 font-bold hover:text-blue-900">Masuk di sini</a>
    </p>
</section>
@endsection

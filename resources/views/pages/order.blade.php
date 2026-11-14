@extends('layouts.app')
@section('title', 'Pesan '.$product->name)
@section('content')
<section class="py-12 max-w-2xl mx-auto">
    <a href="{{ route('products') }}" class="text-blue-700 hover:text-blue-900">&larr; Kembali ke produk</a>
    <h1 class="text-4xl font-bold text-blue-700 mt-5 mb-2">Pesan Produk</h1>
    <p class="text-blue-900/80 mb-8">Lengkapi detail pesanan Anda. Tim kami akan menghubungi Anda untuk konfirmasi.</p>

    <div class="bg-white text-slate-800 overflow-hidden shadow-lg mb-6">
        <div class="bg-blue-600 text-white px-5 py-4 flex items-center justify-between gap-3">
            <h2 class="font-black text-xl">{{ $product->name }}</h2>
            <div class="font-black text-xl">{{ $product->price_label }} {{ $product->unit }}</div>
        </div>
        @if ($product->description)
            <p class="p-5">{{ $product->description }}</p>
        @endif
    </div>

    <form method="POST" action="{{ route('order.store', $product) }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        <div>
            <label for="address" class="block font-bold mb-2">Alamat</label>
            <textarea id="address" name="address" rows="3" maxlength="1000" required
                      class="w-full bg-blue-50 border border-blue-200 px-4 py-3 text-blue-900 focus:outline-none focus:border-blue-600 @error('address') border-red-400 @enderror"
                      placeholder="Masukkan alamat pemasangan atau lokasi layanan">{{ old('address', auth()->user()->address) }}</textarea>
            @error('address') <p class="text-red-300 text-sm mt-2">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="payment_method" class="block font-bold mb-2">Metode Pembayaran</label>
            <select id="payment_method" name="payment_method" required
                    class="w-full bg-blue-50 border border-blue-200 px-4 py-3 text-blue-900 focus:outline-none focus:border-blue-600 @error('payment_method') border-red-400 @enderror">
                <option value="">Pilih metode pembayaran</option>
                @foreach ($paymentMethods as $value => $label)
                    <option value="{{ $value }}" @selected(old('payment_method') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            @error('payment_method') <p class="text-red-300 text-sm mt-2">{{ $message }}</p> @enderror
        </div>
        <div id="bank-account-field" @if (old('payment_method') !== 'bank_transfer') hidden @endif>
            <label for="bank_account_number" class="block font-bold mb-2">Nomor Rekening Pengirim</label>
            <input id="bank_account_number" name="bank_account_number" type="text" maxlength="34"
                   value="{{ old('bank_account_number') }}"
                   @if (old('payment_method') !== 'bank_transfer') disabled @else required @endif
                   class="w-full bg-blue-50 border border-blue-200 px-4 py-3 text-blue-900 focus:outline-none focus:border-blue-600 @error('bank_account_number') border-red-400 @enderror"
                   placeholder="Masukkan nomor rekening yang digunakan untuk transfer">
            @error('bank_account_number') <p class="text-red-300 text-sm mt-2">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="payment_proof" class="block font-bold mb-2">Bukti Transaksi (opsional)</label>
            <input id="payment_proof" name="payment_proof" type="file" accept=".jpg,.jpeg,.png,.pdf"
                   class="w-full bg-blue-50 border border-blue-200 px-4 py-3 text-blue-900 focus:outline-none focus:border-blue-600 @error('payment_proof') border-red-400 @enderror">
            <p class="text-sm text-blue-900/70 mt-1">Format JPG, PNG, atau PDF; maksimal 5 MB.</p>
            @error('payment_proof') <p class="text-red-300 text-sm mt-2">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="notes" class="block font-bold mb-2">Catatan (opsional)</label>
            <textarea id="notes" name="notes" rows="4" maxlength="1000"
                      class="w-full bg-blue-50 border border-blue-200 px-4 py-3 text-blue-900 placeholder-blue-300 focus:outline-none focus:border-blue-600 @error('notes') border-red-400 @enderror"
                      placeholder="Contoh: kebutuhan pemasangan atau informasi tambahan">{{ old('notes') }}</textarea>
            @error('notes') <p class="text-red-300 text-sm mt-2">{{ $message }}</p> @enderror
        </div>
        <button id="submit-order" type="submit" class="w-full bg-blue-600 text-white font-bold px-6 py-3 hover:bg-blue-700">Kirim Pesanan</button>
    </form>
</section>
<script>
    const paymentMethod = document.getElementById('payment_method');
    const bankAccountField = document.getElementById('bank-account-field');
    const bankAccountNumber = document.getElementById('bank_account_number');

    function updateBankAccountField() {
        const isBankTransfer = paymentMethod.value === 'bank_transfer';
        bankAccountField.hidden = !isBankTransfer;
        bankAccountNumber.disabled = !isBankTransfer;
        bankAccountNumber.required = isBankTransfer;
    }

    paymentMethod.addEventListener('change', updateBankAccountField);
    updateBankAccountField();
</script>
@endsection

@php
    $whatsappMessage = 'Halo, saya ingin melakukan pembayaran untuk produk '.$product->name.' ('.$product->price_label.' '.$product->unit.'). Mohon info langkah selanjutnya.';
    $whatsappUrl = 'https://wa.me/'.config('services.whatsapp.number').'?text='.rawurlencode($whatsappMessage);
@endphp
<div class="bg-white text-slate-800 overflow-hidden shadow-lg flex flex-col">
    <div class="bg-blue-600 text-white px-5 py-4 flex items-baseline justify-between gap-3">
        <div class="font-black text-lg leading-tight">{{ $product->name }}</div>
        <div class="text-right shrink-0">
            <div class="font-black text-2xl text-white">{{ $product->price_label }}</div>
            <div class="text-xs">{{ $product->unit }}</div>
        </div>
    </div>
    @if ($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover">
    @endif
    <div class="p-5 flex-1">
        @if ($product->description)
            <p class="text-sm text-slate-600 mb-4">{{ $product->description }}</p>
        @endif
        <ul class="space-y-2 text-sm">
            @foreach ($product->features ?? [] as $f)
                <li class="flex gap-2 border-b border-slate-200 pb-2"><span class="text-teal font-black">&#10003;</span>{{ $f }}</li>
            @endforeach
        </ul>
    </div>
    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="block text-center bg-white text-blue-700 font-bold py-3 hover:bg-blue-100 hover:text-blue-900">Pembayaran</a>
    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="block text-center bg-blue-600 text-white font-bold py-3 hover:bg-blue-700">Bayar Sekarang</a>
</div>

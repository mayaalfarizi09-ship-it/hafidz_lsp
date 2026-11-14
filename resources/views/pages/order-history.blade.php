@extends('layouts.app')
@section('title', 'Riwayat Pesanan')
@section('content')
<section class="py-12">
    <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
        <div>
            <h1 class="text-4xl font-bold text-blue-700 mb-2">Riwayat Pesanan</h1>
            <p class="text-blue-900/80">Pantau status pesanan dan pembayaran Anda.</p>
        </div>
        <a href="{{ route('products') }}" class="bg-blue-600 text-white font-bold px-5 py-3 hover:bg-blue-700">Pesan Produk</a>
    </div>

    @if ($orders->isEmpty())
        <div class="bg-blue-50 border border-blue-200 p-8 text-center">
            <h2 class="text-xl font-bold mb-2">Belum ada pesanan</h2>
            <p class="text-blue-900/80 mb-5">Pesanan yang Anda buat akan muncul di halaman ini.</p>
            <a href="{{ route('products') }}" class="text-blue-700 font-bold hover:text-blue-900">Lihat produk & layanan</a>
        </div>
    @else
        <div class="overflow-x-auto bg-white shadow-lg">
            <table class="w-full text-left text-sm">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th scope="col" class="px-5 py-4">Nomor Pesanan</th>
                        <th scope="col" class="px-5 py-4">Produk</th>
                        <th scope="col" class="px-5 py-4">Tanggal</th>
                        <th scope="col" class="px-5 py-4">Total</th>
                        <th scope="col" class="px-5 py-4">Status Pesanan</th>
                        <th scope="col" class="px-5 py-4">Pembayaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-100">
                    @foreach ($orders as $order)
                        <tr>
                            <td class="px-5 py-4 font-bold">{{ $order->order_number }}</td>
                            <td class="px-5 py-4">{{ $order->product->name }}</td>
                            <td class="px-5 py-4 whitespace-nowrap">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-5 py-4 whitespace-nowrap">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="px-5 py-4 whitespace-nowrap">{{ $order->order_status_label }}</td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                {{ $order->payment_status_label }}
                                @if ($order->payment_method)
                                    <span class="block text-blue-900/70">{{ $paymentMethods[$order->payment_method] ?? $order->payment_method }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $orders->links() }}</div>
    @endif
</section>
@endsection

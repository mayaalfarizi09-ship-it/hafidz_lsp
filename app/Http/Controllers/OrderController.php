<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RuntimeException;

class OrderController extends Controller
{
    public function history(Request $request): View
    {
        return view('pages.order-history', [
            'orders' => $request->user()->orders()->with('product')->latest()->paginate(10),
            'paymentMethods' => Order::PAYMENT_METHODS,
        ]);
    }

    public function create(Product $product): View
    {
        return view('pages.order', [
            'product' => $product,
            'paymentMethods' => Order::PAYMENT_METHODS,
        ]);
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'address' => ['required', 'string', 'max:1000'],
            'payment_method' => ['required', 'string', 'in:'.implode(',', array_keys(Order::PAYMENT_METHODS))],
            'bank_account_number' => ['exclude_unless:payment_method,bank_transfer', 'required', 'string', 'max:34'],
            'payment_proof' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'address.required' => 'Alamat wajib diisi.',
            'address.max' => 'Alamat maksimal 1000 karakter.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
            'payment_method.in' => 'Metode pembayaran yang dipilih tidak valid.',
            'bank_account_number.required' => 'Nomor rekening pengirim wajib diisi untuk transfer bank.',
            'bank_account_number.max' => 'Nomor rekening maksimal 34 karakter.',
            'payment_proof.file' => 'Bukti transaksi harus berupa file.',
            'payment_proof.mimes' => 'Bukti transaksi harus berupa JPG, PNG, atau PDF.',
            'payment_proof.max' => 'Ukuran bukti transaksi maksimal 5 MB.',
            'notes.max' => 'Catatan maksimal 1000 karakter.',
        ]);

        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'local');

            if ($paymentProofPath === false) {
                throw new RuntimeException('Bukti transaksi gagal disimpan.');
            }
        }

        Order::create([
            'order_number' => 'ORD-'.now()->format('YmdHis').'-'.strtoupper(Str::random(4)),
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'total_price' => $product->price,
            'address' => $data['address'],
            'payment_method' => $data['payment_method'],
            'bank_account_number' => $data['bank_account_number'] ?? null,
            'payment_proof_path' => $paymentProofPath,
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()->route('products')->with('success', 'Pesanan berhasil dibuat. Tim kami akan segera menghubungi Anda.');
    }
}

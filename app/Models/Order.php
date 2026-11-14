<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    public const PAYMENT_METHODS = [
        'bank_transfer' => 'Transfer Bank',
        'e_wallet' => 'E-Wallet',
        'qris' => 'QRIS',
    ];

    protected $fillable = [
        'order_number', 'user_id', 'product_id', 'quantity', 'total_price',
        'order_status', 'payment_status', 'address', 'payment_method',
        'bank_account_number', 'payment_proof_path', 'notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getOrderStatusLabelAttribute(): string
    {
        return [
            'pending' => 'Menunggu', 'confirmed' => 'Dikonfirmasi', 'processing' => 'Diproses',
            'completed' => 'Selesai', 'cancelled' => 'Dibatalkan',
        ][$this->order_status] ?? $this->order_status;
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return ['unpaid' => 'Belum Bayar', 'paid' => 'Lunas', 'refunded' => 'Dikembalikan'][$this->payment_status] ?? $this->payment_status;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'unit', 'description', 'features', 'image'];

    protected $casts = ['features' => 'array'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getPriceLabelAttribute(): string
    {
        return 'Rp '.number_format($this->price, 0, ',', '.');
    }
}

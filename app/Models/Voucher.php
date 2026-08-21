<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = ['name', 'type', 'code', 'points_cost', 'stock', 'is_active', 'expires_at', 'description'];

    protected $casts = ['is_active' => 'boolean', 'expires_at' => 'datetime', 'points_cost' => 'integer', 'stock' => 'integer'];

    public function redemptions() { return $this->hasMany(VoucherRedemption::class); }

    public function getTypeLabelAttribute(): string
    {
        return $this->type === 'wifi' ? 'WiFi' : 'Koperasi';
    }
}

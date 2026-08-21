<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherRedemption extends Model
{
    protected $fillable = ['user_id', 'voucher_id', 'voucher_code', 'points_spent', 'status', 'redeemed_at'];
    protected $casts = ['redeemed_at' => 'datetime', 'points_spent' => 'integer'];
    public function user() { return $this->belongsTo(User::class); }
    public function voucher() { return $this->belongsTo(Voucher::class); }
}

<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['username', 'name', 'email', 'password', 'role', 'nis', 'class_name', 'profile_photo', 'points'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }

    public function voucherRedemptions()
    {
        return $this->hasMany(VoucherRedemption::class);
    }

    public function wasteRecords()
    {
        return $this->hasMany(WasteRecord::class);
    }

    public function wasteReports()
    {
        return $this->hasMany(WasteReport::class);
    }
}

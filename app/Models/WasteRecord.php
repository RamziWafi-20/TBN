<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id',
    'image_path',
    'waste_name',
    'waste_type',
    'condition',
    'ai_confidence',
    'estimated_weight',
    'estimated_price',
    'advice',
])]
class WasteRecord extends Model
{
    protected $casts = [
        'ai_confidence' => 'float',
        'estimated_weight' => 'float',
        'estimated_price' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

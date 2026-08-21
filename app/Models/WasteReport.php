<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteReport extends Model
{
    protected $fillable = [
        'code', 'user_id', 'waste_category_id', 'image_path', 'ai_confidence',
        'ai_estimated_weight', 'actual_weight', 'estimated_value', 'actual_value',
        'status', 'notes',
    ];

    protected $casts = [
        'ai_confidence' => 'float',
        'ai_estimated_weight' => 'float',
        'actual_weight' => 'float',
        'estimated_value' => 'float',
        'actual_value' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(WasteCategory::class, 'waste_category_id');
    }

    public function transaction()
    {
        return $this->hasOne(WasteTransaction::class, 'waste_report_id');
    }

    public function getEffectiveWeightAttribute(): float
    {
        return (float) ($this->actual_weight ?? $this->ai_estimated_weight ?? 0);
    }

    public function getEffectiveValueAttribute(): float
    {
        return (float) ($this->actual_value ?? $this->estimated_value ?? 0);
    }
}

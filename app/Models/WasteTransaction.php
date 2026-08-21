<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteTransaction extends Model
{
    protected $fillable = [
        'waste_report_id', 'type', 'gross_value', 'processing_cost',
        'selling_value', 'net_profit', 'transaction_date',
    ];

    protected $casts = [
        'gross_value' => 'float',
        'processing_cost' => 'float',
        'selling_value' => 'float',
        'net_profit' => 'float',
        'transaction_date' => 'date',
    ];

    public function report()
    {
        return $this->belongsTo(WasteReport::class, 'waste_report_id');
    }
}

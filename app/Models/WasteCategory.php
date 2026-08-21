<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteCategory extends Model
{
    protected $table = 'waste_categories';

    protected $fillable = [
        'name', 'material', 'default_price_per_kg', 'color',
    ];

    protected $casts = [
        'default_price_per_kg' => 'float',
    ];

    public function reports()
    {
        return $this->hasMany(WasteReport::class, 'waste_category_id');
    }
}

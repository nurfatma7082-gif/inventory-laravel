<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sale_number',
        'total',
        'status',
        'sold_at',
        'notes',
    ];

    protected $casts = [
        'sold_at' => 'datetime',
        'total' => 'decimal:2',
    ];

    /**
     * Sale belongsTo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Sale hasMany SaleItems
     */
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    // Alias for compatibility
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}

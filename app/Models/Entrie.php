<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrie extends Model
{
    protected $fillable = [
        'product_id',
        'provider_id',
        'branch_id',
        'quantity',
        'unit_cost',
        'invoice_number',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

}


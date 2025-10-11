<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'barcode',
        'image_url',
        'description',
        'price',
        'min_stock',
        'category_id',
        'status',
    ];
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}

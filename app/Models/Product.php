<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['shop_id','name', 'base_price', 'description', 'category', 'stocks'];

    public function variations() {
        return $this->hasMany(ProductVariation::class, 'product_id');
    }

    public function shop() {
        return $this->belongsTo(Shop::class);
    }
}

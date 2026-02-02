<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductItem extends Model
{

    protected $fillable = ['product_id', 'price', 'stocks'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function configurations() {
        return $this->hasMany(ProductConfiguration::class);
    }
}

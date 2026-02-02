<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariationOption extends Model
{
    protected $fillable = ['product_variation_id', 'name', 'image_url'];

    public function variation() {
        return $this->belongsTo(ProductVariation::class);
    }

    public function configurations() {
        return $this->hasMany(ProductConfiguration::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductConfiguration extends Model
{
    protected $fillable = [
        'product_item_id', 'product_variation_id', 'product_variation_option_id'
        ];

    public function item() {
        return $this->belongsTo(ProductItem::class);
    }

    public function option() {
        return $this->belongsTo(ProductVariationOption::class);
    }

    public function variation() {
        return $this->belongsTo(ProductVariation::class);
    }
}

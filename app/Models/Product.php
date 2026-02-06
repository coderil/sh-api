<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Product extends Model implements Searchable
{
    use HasFactory;

    protected $fillable = ['shop_id','name', 'base_price', 'description', 'category', 'stocks'];

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this, 
            $this->name,
        );
    }

    public function variations() {
        return $this->hasMany(ProductVariation::class, 'product_id');
    }

    public function shop() {
        return $this->belongsTo(Shop::class);
    }

    public function options() {
        return $this->hasManyThrough(ProductVariationOption::class, ProductVariation::class);
    }
    
}

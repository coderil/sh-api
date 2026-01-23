<?php

namespace App\Models\Product;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['name', 'price', 'description', 'category'];

    protected static function newFactory() {
        return ProductFactory::new();
    }
}

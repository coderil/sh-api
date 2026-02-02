<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id', 'name', 'description', 'logo'
    ];

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id'); 
    }

    public function products() {
        return $this->hasMany(Product::class);
    }
}

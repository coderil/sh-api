<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Shop extends Model
{
    protected $fillable = [
        'owner_id', 'name', 'description', 'logo'
    ];

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id'); 
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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

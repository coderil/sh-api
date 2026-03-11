<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    protected $fillable = ['code_hash', 'expires_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}

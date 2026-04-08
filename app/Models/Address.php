<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'full_name', 'phone_number', 'barangay_id', 'postal_code','address_line', 'is_default'
    ];

    protected $table = 'addresses';

    public function barangay() {
        return $this->belongsTo(Barangay::class, 'barangay_code');
    }

    public function addressable() {
        return $this->morphTo();
    }
}

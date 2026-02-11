<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Shop extends Model implements Searchable
{
    use HasFactory;

    protected $fillable = [
        'owner_id', 'name', 'description', 'logo', 'location', 'vacation_mode'
    ];

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->name,
        );  
    }

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id'); 
    }

    public function products() {
        return $this->hasMany(Product::class);
    }
}

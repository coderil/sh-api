<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static where(array $param)
 */
class Region extends Model
{
    use HasFactory;

    // protected $table = config('psgc.tables.regions', 'regions');
    protected $table = 'regions';

    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['code','name','short_name'];
    protected $hidden = ['created_at', 'updated_at'];

    public function getSearchable(): array
    {
        return [
            'query' => ['code'],
            'query_like' => ['name','short_name'],
        ];
    }

    public function provinces(): HasMany
    {
        return $this->hasMany(Province::class, 'region_code', 'code');
    }
}
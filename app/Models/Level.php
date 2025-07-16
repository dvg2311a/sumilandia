<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description'
    ];

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Get the description of the level.
     *
     * @return string|null
     */
    public function getDescriptionAttribute($value)
    {
        return $value ?: 'No description available';
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }
}


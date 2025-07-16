<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Get the name of the level.
     *
     * @return string
     */
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
}

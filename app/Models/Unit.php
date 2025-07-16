<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Unit extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'level_id',
    ];

    /**
     * Get the name of the unit.
     *
     * @return string
     */
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Get the description of the unit.
     *
     * @return string|null
     */
    public function getDescriptionAttribute($value)
    {
        return $value ?: 'No description available';
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }
}

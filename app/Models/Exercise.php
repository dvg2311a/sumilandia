<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $fillable = [
        'prompt',
        'options', // Optional field for multiple choice options
        'solution',
        'explanation',
    ];

    /**
     * Get the options as an array.
     *
     * @return array
     */
    public function getOptionsAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    /**
     * Set the options as a JSON string.
     *
     * @param array $value
     */
    public function setOptionsAttribute(array $value)
    {
        $this->attributes['options'] = json_encode($value);
    }
}

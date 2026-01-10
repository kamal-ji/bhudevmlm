<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    // Table name (optional if following Laravel naming conventions)
    protected $table = 'states';

    // Mass assignable columns
    protected $fillable = [
        'country_id',
        'name',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'country_id' => 'integer',
    ];

    /**
     * A state belongs to a country
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
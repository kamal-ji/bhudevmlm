<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    protected $fillable = [
        'name',
        'country_code',
        'iso_code',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function states()
    {
        return $this->hasMany(State::class, 'country_id');
    }
}

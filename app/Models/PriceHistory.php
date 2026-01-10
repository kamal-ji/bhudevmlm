<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'old_price',
        'new_price',
        'reason',
        'changed_by'
    ];

    // Relationships
    public function package()
    {
        return $this->belongsTo(ServicePackage::class);
    }

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
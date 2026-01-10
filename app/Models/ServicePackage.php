<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_category_id', 'name', 'slug', 'description', 'price',
        'duration_days', 'commission_amount', 'commission_percentage',
        'commission_type', 'features', 'status'
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'commission_percentage' => 'decimal:2',
    ];

    // Relationships
    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function orders()
    {
        return $this->hasMany(ServiceOrder::class);
    }

    // Calculate commission amount
    public function calculateCommission($amount = null)
    {
        $amount = $amount ?? $this->price;
        
        switch ($this->commission_type) {
            case 'fixed':
                return $this->commission_amount;
            case 'percentage':
                return $amount * ($this->commission_percentage / 100);
            case 'both':
                return $this->commission_amount + ($amount * ($this->commission_percentage / 100));
            default:
                return 0;
        }
    }

   
}
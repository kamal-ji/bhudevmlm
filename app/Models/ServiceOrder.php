<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'member_id', 'service_package_id', 'service_category_id',
        'referrer_id', 'amount', 'commission_amount', 'commission_paid',
        'status', 'referral_code_used', 'notes', 'order_date'
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'amount' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'commission_paid' => 'boolean',
    ];

    // Generate order number
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'SVC-' . date('Ymd') . '-' . strtoupper(\Str::random(6));
            }
        });
    }

    // Relationships
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function servicePackage()
    {
        return $this->belongsTo(ServicePackage::class);
    }

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function commission()
    {
        return $this->hasOne(Commission::class, 'order_id');
    }
}
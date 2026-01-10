<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberServiceCategory extends Model
{
    use HasFactory;

    protected $table = 'member_service_categories';

    protected $fillable = [
        'member_id', 'service_category_id', 'referral_code',
        'commission_rate', 'status', 'total_sales', 'total_commission',
        'referral_count', 'joined_at'
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'total_sales' => 'decimal:2',
        'total_commission' => 'decimal:2',
    ];

    // Relationships
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function orders()
    {
        return $this->hasMany(ServiceOrder::class, 'referral_code_used', 'referral_code');
    }

    // Generate referral code
    public static function generateReferralCode($member, $serviceCategory)
    {
        $prefix = strtoupper(substr($serviceCategory->name, 0, 3));
        $memberCode = strtoupper(substr($member->name, 0, 3));
        $random = strtoupper(\Str::random(4));
        
        return $prefix . '-' . $memberCode . '-' . $random;
    }
}
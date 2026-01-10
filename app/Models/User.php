<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role_id',
        'sponsor_id',
        'member_id',
        'name',
        'email',
        'password',
        'first_name',        // Added
        'last_name',         // Added
        'image',             // Added
        'mobile',            // Added
        'address1',          // Added
        'address2',          // Added
        'city',              // Added
        'zip', 
        'countryid',              // Added
        'regionid',          // Added
        'dob',               // Added
        'anniversary',       // Added
        'status',
        'registration_type',
        'approved_by',
        'approved_at',
        'created_by_admin',
        'referral_code',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'string',
        ];
    }

     // Scopes for easy filtering
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'countryid');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'regionid');
    }
    public function getProfileImageAttribute()
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('assets/backend/img/profiles/avatar-01.jpg');
    }

    // Relationships
    public function serviceCategories()
    {
        return $this->belongsToMany(ServiceCategory::class, 'member_service_categories')
                    ->withPivot('referral_code', 'commission_rate', 'status', 'total_sales', 'total_commission', 'referral_count')
                    ->withTimestamps();
    }

    public function activeServiceCategories()
    {
        return $this->serviceCategories()->wherePivot('status', 'active');
    }

    public function memberServiceCategories()
    {
        return $this->hasMany(MemberServiceCategory::class, 'member_id');
    }

    public function serviceOrders()
    {
        return $this->hasMany(ServiceOrder::class, 'member_id');
    }

    public function referredOrders()
    {
        return $this->hasMany(ServiceOrder::class, 'referrer_id');
    }
     // Sponsor/Parent relationship
    public function sponsor()
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }

     // Get active sponsors only (for dropdown)
    public function scopeActiveSponsors($query)
    {
        return $query->whereHas('role', function ($q) {
                $q->where('name', 'member');
            })
            ->where('status', 'active')
            ->whereNotNull('approved_at');
    }
   // Get full name
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    // Get sponsor info
    public function getSponsorInfoAttribute()
    {
        if ($this->sponsor) {
            return $this->sponsor->full_name . ' (' . $this->sponsor->member_id . ')';
        }
        return 'No Sponsor';
    }

    // Generate member ID (optional but useful for MLM)
    public static function generateMemberId()
    {
        $prefix = 'MEM';
        $lastMember = self::whereHas('role', function ($q) {
            $q->where('name', 'member');
        })->orderBy('id', 'desc')->first();
        
        $nextNumber = $lastMember ? intval(substr($lastMember->member_id, 3)) + 1 : 1;
        return $prefix . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }

    public static function generateReferralCode()
{
    $prefix = 'BHU';

    do {
        $code = $prefix . strtoupper(Str::random(6));
    } while (self::where('referral_code', $code)->exists());

    return $code;
}

}

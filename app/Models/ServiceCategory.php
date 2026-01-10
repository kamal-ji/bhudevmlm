<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'commission_rate', 
        'status', 'icon', 'color', 'sort_order'
    ];

    // Relationships
    public function members()
    {
        return $this->belongsToMany(User::class, 'member_service_categories','service_category_id','member_id')
                    ->withPivot('referral_code', 'commission_rate', 'status', 'total_sales', 'total_commission')
                    ->withTimestamps();
    }

     // Or create a separate relationship for withSum
    public function memberServices()
    {
        return $this->hasMany(MemberServiceCategory::class);
    }

    public function activeMembers()
    {
        return $this->members()->wherePivot('status', 'active');
    }

    public function packages()
    {
        return $this->hasMany(ServicePackage::class);
    }

    public function activePackages()
    {
        return $this->packages()->where('status', 'active');
    }

    public function orders()
    {
        return $this->hasMany(ServiceOrder::class);
    }

    // Generate unique slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = \Str::slug($category->name);
            }
        });
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    const TYPE_USER = 1;
    const TYPE_CORPORATE = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Scope a query to only include users of a given type.
     *
     * @param  Builder  $query
     * @param  mixed  $type
     * @return Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get addresses for the User.
     */
    public function userAddresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    /**
     * Get wishLists for the User.
     */
    public function wishLists()
    {
        return $this->hasMany(WishList::class);
    }

    /**
     * Get orders for the User.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get Related reviews for the user.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get Related reviews abuses for the user.
     */
    public function reviewsAbuses()
    {
        return $this->hasMany(ReviewAbuse::class);
    }

    /**
     * Get cart for the User.
     */
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public static function subscribedUsers()
    {
        return User::where('type', Self::TYPE_USER)
            ->where('is_subscribed', '1')
            ->where('is_active', '1')
            ->get(['id', 'first_name', 'last_name']);
    }

    public static function subscribedCompanies()
    {
        return User::where('type', Self::TYPE_CORPORATE)
            ->where('is_subscribed', '1')
            ->where('is_active', '1')
            ->where('is_corporate_accepted', '1')
            ->get(['id', 'company']);
    }
}

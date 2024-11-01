<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string id
 * @property string name
 * @property string email
 * @property string password
 * @property null|string phone
 * @property null|string address
 * @property null|string description
 * @property null|string avatar
 * @property null|string cover
 * @property null|string google_id
 * @property null|string facebook_id
 * @property null|string apple_id
 * @property Product[] wish_list
 * @property Collection|Product[] recentViewedProducts
 */
class Customer extends Authenticatable
{
    use Uuid, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'description', 'avatar', 'cover',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function wishList(): BelongsToMany
    {
        return $this
            ->belongsToMany(Product::class, 'customer_product_wish_list', 'customer_id', 'product_id')
            ->withTimestamps();
    }

    public function recentViewedProducts(): BelongsToMany
    {
        return $this
            ->belongsToMany(Product::class, 'product_recent_viewed', 'customer_id', 'product_id')
            ->withTimestamps()
            ->orderByPivot('created_at', 'desc');
    }
}

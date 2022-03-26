<?php

namespace App\Models;

use App\Types\RoleType;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, InteractsWithMedia, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile')->singleFile();
    }

    public function profilePicture()
    {
        $profile = $this->getFirstMediaUrl('profile');

        return $profile;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(RoleType::ADMINISTRATOR);
    }

    public function isCashier(): bool
    {
        return $this->hasRole(RoleType::CASHIER);
    }

    public function isCustomer(): bool
    {
        return $this->hasRole(RoleType::CUSTOMER);
    }

    public function inquires()
    {
        return $this->hasMany(Inquire::class);
    }

    public function replyInquires()
    {
        return $this->hasMany(ReplyInquire::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function onlinePayments()
    {
        return $this->hasMany(OnlinePayment::class);
    }
}

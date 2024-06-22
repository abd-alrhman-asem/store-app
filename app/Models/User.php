<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'email',
        'password',
        'address',
        'ip_address',
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
        'password' => 'hashed',
        'address' => 'array',

    ];

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return BelongsTo
     */
    public function userByIp(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ip_address', 'ip_address');
    }

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function ($user) {
            $user->address = $user->composeAddress();
        });
    }


    /**
     * Compose the address from postal_code, city, and country.
     *
     * @return string
     */
    protected function composeAddress(): string
    {
        $address = "{$this->postal_code}-{$this->city}-{$this->country}";
        unset($this->postal_code, $this->city, $this->country);
        return $address;
    }
}

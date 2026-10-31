<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Available user roles.
     */
    public const ROLE_USER = 'user';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_OWNER = 'owner';

    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'bio',
        'avatar_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check whether the user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check whether the user is the platform owner.
     */
    public function isOwner(): bool
    {
        return $this->hasRole(self::ROLE_OWNER);
    }

    /**
     * Check whether the user is an admin or owner.
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, [
            self::ROLE_ADMIN,
            self::ROLE_OWNER,
        ], true);
    }

    /**
     * User's published quotes.
     */
    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    /**
     * User's likes.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * User's favorite quotes.
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Legacy quotes added by this user.
     */
    public function legacyQuotes(): HasMany
    {
        return $this->hasMany(LegacyQuote::class, 'created_by');
    }
}

<?php

namespace App\Models;

// use Heritage\Contracts\Auth\MustVerifyEmail;
use Heritage\Database\Eloquent\Factories\HasFactory;
use Heritage\Database\Eloquent\Relations\HasMany;
use Heritage\Foundation\Auth\User as Authenticatable;
use Heritage\Notifications\Notifiable;
use Ugarit\Passport\Contracts\OAuthenticatable;
use Ugarit\Passport\HasApiTokens;

class User extends Authenticatable implements OAuthenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'github_id',
        'github_username',
        'avatar',
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
        ];
    }

    /**
     * Get the user's statuses.
     */
    public function statuses(): HasMany
    {
        return $this->hasMany(UserStatus::class);
    }

    /**
     * Get the user's bookmarked links.
     */
    public function userLinks(): HasMany
    {
        return $this->hasMany(UserLink::class);
    }

    /**
     * Get the user's link notes.
     */
    public function linkNotes(): HasMany
    {
        return $this->hasMany(LinkNote::class);
    }
}

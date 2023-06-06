<?php

namespace App\Models;

use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property string $name
 * @property string $email
 * @property string $password
 * @property \DateTime|null $email_verified_at
 * @property \DateTime|null $created_at
 * @property \DateTime|null $updated_at
 * @property \DateTime|null $deleted_at
 */
class User extends Authenticatable implements JWTSubject
{
    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
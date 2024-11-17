<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * User Model
 *
 * This class represents the 'User' model, which is used for authentication and JWT token generation.
 * It extends the Authenticatable class and implements the JWTSubject interface for token handling.
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',        // User's name
        'email',       // User's email address
        'password',    // User's password
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',       // Hides the password attribute from serialization
        'remember_token', // Hides the remember_token attribute from serialization
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Casts email_verified_at to a datetime object
            'password' => 'hashed',            // Ensures password is stored as hashed
        ];
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Retrieves the primary key of the user
    }

    /**
     * Return any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return []; // No custom claims by default
    }
}

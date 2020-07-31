<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * The User Entity
 *
 * @author Jason Marchalonis
 * @since 1.0
 * @package App
 * @package Authenticatable
 */
class User extends Authenticatable
{
    // Import the required traits; we handle our auth with Passport here
    use Notifiable, HasApiTokens;

    /**
     * Setup the Notifications Association
     */
    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Date;

/**
 * Class User
 * @property int id;
 * @property string email;
 * @property string password;
 * @property string name;
 * @property string surname;
 * @property string gender;
 * @property date birthday;
 * @property string skills;
 * @property array interests;
 * @property boolean isAdmin;
 * @mixin Collection;
 * @mixin Builder
 */

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'name', 'surname', 'gender', 'birthday', 'skills', 'interests'
    ];

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
        'isAdmin' => 'boolean',
    ];
}

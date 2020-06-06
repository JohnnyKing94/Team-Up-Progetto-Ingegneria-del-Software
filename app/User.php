<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property array $interestsList;
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
        'email', 'password', 'name', 'surname', 'gender', 'birthday', 'skills', 'interests',
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

    /**
     * Attributes for this model
     *
     * @var array
     */

    private static $interestsList = [
        'Svago',
        'Sport',
        'Tecnologia',
        'Economia',
        'Politica',
        'Medicina',
        'Volontariato',
        'Viaggio',
        'Arte & Disegno',
        'Musica',
        'Lettura',
        'Videogioco',
    ];

    /**
     * Getter for all defined labels
     *
     * @return array
     */
    protected static function getInterests()
    {
        return self::$interestsList;
    }

    /**
     * Give space between interests
     *
     * @param $interests
     * @return string
     */
    protected static function spacingInterests($interests)
    {
        return str_replace(',', ', ', $interests);
    }

    /**
     * Create array for the interests
     *
     * @param $interests
     * @return array
     */
    protected static function arrayInterests($interests)
    {
        return explode(',', $interests);
    }

    /**
     * Create relationship between User and Project
     *
     * @return hasMany
     */
    public function asLeader()
    {
        return $this->hasMany('App\Project', 'leader_id');
    }

    /**
     * Create participation_requests relationship between User and Project
     *
     * @return BelongsToMany
     */
    public function projectRequests()
    {
        return $this->belongsToMany('App\Project', 'participation_requests', 'teammate_id', 'project_id')->withPivot('reason', 'identifier', 'created_at');
    }

    /**
     * Create teams relationship between User and Project
     *
     * @return BelongsToMany
     */
    public function asTeammate()
    {
        return $this->belongsToMany('App\Project', 'teams', 'teammate_id', 'project_id')->withPivot('join_date');
    }
}

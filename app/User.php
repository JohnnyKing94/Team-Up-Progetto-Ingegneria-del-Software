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
use Illuminate\Support\Str;

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
 * @property string slug;
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
        'email', 'password', 'name', 'surname', 'gender', 'birthday', 'skills', 'interests', 'slug',
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
     * Creates unique user slug
     *
     * @return string
     */
    public static function createSlugCode()
    {
        $exists = true;
        while ($exists) {
            $slugCode = Str::random(16);
            $check = self::where('slug', $slugCode)->first();
            if(!$check){
                $exists = false;
            }
        }
        return $slugCode;
    }

    /**
     * Getter for all defined labels
     *
     * @return array
     */
    public static function getInterests()
    {
        return self::$interestsList;
    }

    /**
     * Give space between interests
     *
     * @param $interests
     * @return string
     */
    public static function spacingInterests($interests)
    {
        return str_replace(',', ', ', $interests);
    }

    /**
     * Create array for the interests
     *
     * @param $interests
     * @return array
     */
    public static function arrayInterests($interests)
    {
        return explode(',', $interests);
    }

    /**
     * Checker if the user is in a pending status on a specific project
     *
     * @param $userID
     * @param $project
     * @return boolean
     */
    public static function isPending($userID, $project) {
        return ParticipationRequest::where('teammate_id', $userID)->where('project_id', $project->id)->exists();
    }

    /**
     * Checker if the user is in a teammate on a specific project
     *
     * @param $userID
     * @param $project
     * @return boolean
     */
    public static function isTeammate($userID, $project) {
        return Teammate::where('teammate_id', $userID)->where('project_id', $project->id)->exists();
    }

    /**
     * Checker if the user is in a leader on a specific project
     *
     * @param $userID
     * @param $project
     * @return boolean
     */
    public static function isLeader($userID, $project) {
        return Project::where('leader_id', $userID)->where('id', $project->id)->exists();
    }

    /**
     * Checker if the user is in an admin
     *
     * @param $userID
     * @return boolean
     */
    public static function isAdmin($userID) {
        return User::where('id', $userID)->where('isAdmin', 1)->exists();
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
        return $this->belongsToMany('App\Project', 'participation_requests', 'teammate_id', 'project_id')->withPivot('reason', 'identifier', 'date');
    }

    /**
     * Create teams relationship between User and Project
     *
     * @return BelongsToMany
     */
    public function asTeammate()
    {
        return $this->belongsToMany('App\Project', 'teammates', 'teammate_id', 'project_id')->withPivot('identifier', 'date');
    }

    /**
     * Create messages relationship between User and Project
     *
     * @return BelongsToMany
     */
    public function projectMessages()
    {
        return $this->belongsToMany('App\Project', 'messages', 'user_id', 'project_id')->withPivot('date');
    }
}

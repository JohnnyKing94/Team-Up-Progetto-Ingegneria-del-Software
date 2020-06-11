<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Class Project
 * @property int id;
 * @property string name;
 * @property string description;
 * @property array labels;
 * @property int leader_id;
 * @property string slug;
 * @property array $labelsList;
 * @mixin Collection
 * @mixin Builder
 */

class Project extends Model
{
    /**
     * Database for this model
     */
    protected $table = 'projects';

    /**
     * Attributes for this model
     */
    protected $fillable = [
        'name',
        'description',
        'labels',
        'leader_id',
        'slug',
    ];

    /**
     * Attributes for this model
     *
     * @var array
     */
    private static $labelsList = [
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
     * Creates unique project slug
     *
     * @return string
     */
    protected static function createSlugCode()
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
    protected static function getLabels()
    {
        return self::$labelsList;
    }

    /**
     * Give space between interests
     *
     * @param $labels
     * @return string
     */
    protected static function spacingLabels($labels)
    {
        return str_replace(',', ', ', $labels);
    }

    /**
     * Create array for the interests
     *
     * @param $labels
     * @return array
     */
    protected static function arrayLabels($labels)
    {
        return explode(',', $labels);
    }

    /**
     * Create relationship between Project and User
     *
     * @return BelongsTo
     */
    public function leader()
    {
        return $this->belongsTo('App\User', 'leader_id');
    }

    /**
     * Create participation_requests relationship between Project and User
     *
     * @return BelongsToMany
     */
    public function userRequests()
    {
        return $this->belongsToMany('App\User', 'participation_requests', 'project_id', 'teammate_id')->withPivot('reason', 'identifier', 'date');
    }

    /**
     * Create teams relationship between Project and User
     *
     * @return BelongsToMany
     */
    public function userTeam()
    {
        return $this->belongsToMany('App\User', 'teammates', 'project_id', 'teammate_id')->withPivot('identifier', 'date');
    }

    /**
     * Create messages relationship between Project and User
     *
     * @return BelongsToMany
     */
    public function userMessages()
    {
        return $this->belongsToMany('App\User', 'messages', 'project_id', 'user_id')->withPivot('date');
    }

    public function hasUser($user_id)
    {
        foreach ($this->userMessages as $user) {
            if($user->id == $user_id) {
                return true;
            }
        }
    }
}

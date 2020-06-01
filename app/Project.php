<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class Project
 * @property int id;
 * @property string name;
 * * @property string description;
 * @property array labels;
 * @property int leader_id;
 * @property string slug;
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
     * Creates unique project slug
     */
    protected static function createProjectSlug()
    {
        $exists = true;
        while ($exists) {
            $slug = Str::random(15);
            $check = self::where('slug', $slug)->first();
            if(!$check){
                $exists = false;
            }
        }
        return $slug;
    }
    public function leader()
    {
        return $this->belongsTo('App\User', 'leader_id');
    }
}

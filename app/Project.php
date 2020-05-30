<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'ownerid',
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
        return $this->belongsTo('App\User', 'ownerid');
    }
}

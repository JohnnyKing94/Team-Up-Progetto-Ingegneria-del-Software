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
            $slugCode = Str::random(15);
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
     * Create relationship between User and Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leader()
    {
        return $this->belongsTo('App\User', 'leader_id');
    }
}

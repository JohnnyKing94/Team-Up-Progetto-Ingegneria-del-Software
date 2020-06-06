<?php

namespace App;

use Cassandra\Timestamp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class Team
 * @property int id;
 * @property int teammate_id;
 * @property int project_id;
 * @property string identifier;
 * @property timestamp join_date;
 * @mixin Collection;
 * @mixin Builder
 */

class Team extends Model
{
    public $timestamps = ["join_date"];
    const CREATED_AT = null;
    const UPDATED_AT = null;

    /**
     * Database for this model
     */
    protected $table = 'teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teammate_id',
        'project_id',
        'identifier',
        'join_date'
    ];

    /**
     * Creates unique project identifier
     *
     * @return string
     */
    protected static function createIdentifier()
    {
        $exists = true;
        while ($exists) {
            $identifier = Str::random(16);
            $check = self::where('identifier', $identifier)->first();
            if(!$check){
                $exists = false;
            }
        }
        return $identifier;
    }
}
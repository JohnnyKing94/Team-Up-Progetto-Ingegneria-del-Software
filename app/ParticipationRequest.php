<?php

namespace App;

use Cassandra\Timestamp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class ParticipationRequest
 * @property int id;
 * @property int teammate_id;
 * @property int project_id;
 * @property string reason;
 * @property string identifier;
 * @property timestamp date;
 * @mixin Collection;
 * @mixin Builder
 */

class ParticipationRequest extends Model
{
    public $timestamps = ["date"];
    const UPDATED_AT = null;

    /**
     * Database for this model
     */
    protected $table = 'participation_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teammate_id',
        'project_id',
        'reason',
        'identifier',
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
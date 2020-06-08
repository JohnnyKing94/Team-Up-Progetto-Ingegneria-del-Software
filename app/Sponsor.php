<?php

namespace App;

use Cassandra\Timestamp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Sponsor
 * @property int id;
 * @property string title;
 * @property string description;
 * @property int project_id;
 * @property timestamp date;
 * @mixin Collection
 * @mixin Builder
 */

class Sponsor extends Model
{
    public $timestamps = ["date"];
    const CREATED_AT = null;
    const UPDATED_AT = null;

    /**
     * Database for this model
     */
    protected $table = 'sponsors';

    /**
     * Attributes for this model
     */
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'date',
    ];

    /**
     * Create relationship between Sponsor and Project
     *
     * @return BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }
}

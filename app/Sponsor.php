<?php

namespace App;

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
 * @mixin Collection
 * @mixin Builder
 */

class Sponsor extends Model
{
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

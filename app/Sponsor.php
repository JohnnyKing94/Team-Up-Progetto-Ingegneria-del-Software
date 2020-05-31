<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Project
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

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }
}

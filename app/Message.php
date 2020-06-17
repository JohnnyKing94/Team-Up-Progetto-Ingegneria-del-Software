<?php

namespace App;

use Cassandra\Timestamp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Message
 * @property int id;
 * @property int teammate_id;
 * @property int project_id;
 * @property string message;
 * @property timestamp date;
 * @mixin Collection;
 * @mixin Builder
 */

class Message extends Model
{
    public $timestamps = ["date"];
    const CREATED_AT = null;
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['teammate_id', 'project_id' ,'message', 'date'];

    public function user(){
        return $this->belongsTo('App\User', 'teammate_id');
    }

    public function project(){
        return $this->belongsTo('App\Project', 'project_id');
    }
}
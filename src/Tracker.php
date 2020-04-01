<?php

namespace Sardoj\Clockify;

use Illuminate\Database\Eloquent\SoftDeletes;
use Uccello\Core\Database\Eloquent\Model;
use Uccello\Core\Support\Traits\UccelloModule;

class Tracker extends Model
{
    use SoftDeletes;
    use UccelloModule;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trackers';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'date_start',
        'time_start',
        'date_end',
        'time_end',
        'description',
        'project_id',
        'domain_id'
    ];

    protected function initTablePrefix()
    {
        $this->tablePrefix = 'clockify_';
    }

    public function project()
    {
        return $this->belongsTo(\Sardoj\Clockify\Project::class);
    }

    /**
    * Returns record label
    *
    * @return string
    */
    public function getRecordLabelAttribute() : string
    {
        return $this->id;
    }
}
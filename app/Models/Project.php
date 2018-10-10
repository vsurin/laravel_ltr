<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * Associated with the model table.
     *
     * @var string
     */
    protected $table = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'descrription', 'organization', 'start', 'end', 'role', 'links', 'skils', 'type_id',
    ];

    /**
     * todo: написать документацию
     */
    public function getTypes()
    {
        return $this->hasOne('App\Models\ProjectType', 'id');
    }
}

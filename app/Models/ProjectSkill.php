<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectSkill extends Model
{
    /**
     * Associated with the model table.
     *
     * @var string
     */
    protected $table = 'projects_skills';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id', 'value',
    ];
}

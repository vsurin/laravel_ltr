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
        'title', 'descrription', 'organization', 'start', 'end', 'role', 'links', 'skils', 'type',
    ];

    /**
     * Get types
     *
     * @return array
     */
    public function getTypes()
    {
        return [
            'Work' => 'Work',
            'Book' => 'Book',
            'Course' => 'Course',
            'Blog' => 'Blog',
            'Other' => 'Other'
        ];
    }

    /**
     * Set Filter
     *
     * @param $query
     * @return mixed
     */
    public function scopeFilter($query)
    {
        if (request('title')) {
            $query->where('title', 'like', '%'.request('title').'%');
        }

        if (request('organization')) {
            $query->where('organization', 'like', '%'.request('organization').'%');
        }

        if (request('filtertype')) {
            $query->where('type', 'like', '%'.request('filtertype').'%');
        }

        return $query;
    }
}

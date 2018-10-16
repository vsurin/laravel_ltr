<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ProjectRulesTrait;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    use ProjectRulesTrait;

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
        'title', 'descrription', 'organization', 'start', 'end', 'role', 'link', 'skils', 'type',
    ];

    protected $guarded = ['skills'];

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

    /**
     * Get the comments for the blog post.
     */
    public function skills()
    {
        return $this->hasMany('App\Models\ProjectSkill');
    }

    /**
     * Create skills
     *
     * @param $request
     * @param $id
     */
    public static function createSkills($request, $id)
    {
        DB::table('projects_skills')
            ->where('project_id', '=', $id)
            ->delete();

        $project = $request->All();

        if (empty($project['skills'])) {
            return false;
        }

        foreach ($project['skills'] as $value) {
            $data = [
                'project_id' => $id,
                'value' => $value
            ];

            ProjectSkill::create($data);
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ProjectRulesTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

    /**
     * @var array
     */
    protected $guarded = ['skills'];

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
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
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
     * @return bool
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

    /**
     * @return array
     */
    public function getRoles()
    {
        return [
            'admin' => 'admin',
            'user' => 'user',
        ];
    }
}

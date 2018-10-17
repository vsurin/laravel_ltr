<?php

namespace App\Http\Traits;

use App\Http\Traits\ProjectTypesTrait;

trait ProjectRulesTrait
{
    use ProjectTypesTrait;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $regex = ' /^https?:\/\/?([\w\.]+)\.([a-z]{2,6}\.?)(\/[\w\.]*)*\/?$/';

        return [
            'title' => 'required|max:255',
            'descrription' => 'required|max:2000',
            'role' => 'required|max:255|in:admin,user',
            'type' => 'required|max:255|in:'.implode(',',$this->getTypes()),
            'start' => 'date_format:Y-m-d',
            'end' => 'date_format:Y-m-d',
            'organization' => 'max:255',
            'link' => 'max:255|regex:'.$regex,
        ];
    }
}
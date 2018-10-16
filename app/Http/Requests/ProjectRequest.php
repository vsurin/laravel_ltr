<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Traits\ProjectRulesTrait;

class ProjectRequest extends FormRequest
{
    use ProjectRulesTrait;
}

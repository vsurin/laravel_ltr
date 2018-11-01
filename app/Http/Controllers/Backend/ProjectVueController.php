<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class ProjectVueController extends Controller
{
    public function index()
    {
        return view('backend.project-vue.index');
    }
}

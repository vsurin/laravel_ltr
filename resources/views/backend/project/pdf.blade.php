<!DOCTYPE html>
<html>
<head>
    <title>{{ $project->title }}</title>
</head>
<body>
<h1>{{ $project->title }}</h1>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div>
            <label>Title:</label>
            {{ $project->title }}
        </div>
        <div>
            <label>Organization:</label>
            {!! $project->organization !!}
        </div>
        <div>
            <label>Start:</label>
            {!! $project->start !!}
        </div>
        <div>
            <label>End:</label>
            {!! $project->end !!}
        </div>
        <div>
            <label>Role:</label>
            {!! $project->role !!}
        </div>
        <div>
            <label>Link:</label>
            {!! $project->link !!}
        </div>
        <div>
            <label>Type:</label>
            {!! $project->type !!}
        </div>
        <div>
            <label>Skils:</label>
            @foreach ($project->skills as $skill)
                @if($project->skills->last() != $skill)
                    {{ $skill->value }},
                @else
                    {{ $skill->value }}
                @endif
            @endforeach
        </div>
        <div>
            <label>Description:</label>
            {!! $project->descrription !!}
        </div>
    </div>
</div>
</body>


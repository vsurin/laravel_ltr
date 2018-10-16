@extends('backend.layouts.default')

@section('content_header')
    <h1>Show project</h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Show project</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-primary" id="generate" href="{{ route('admin.project.pdf') }}/{{ $project->id }}">Generate PDF</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div>
                <label>Title:</label>
                {{ $project->title }}
            </div>
            <div>
                <label>E-Mail:</label>
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
@endsection
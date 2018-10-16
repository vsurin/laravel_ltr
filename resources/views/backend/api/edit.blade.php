@extends('adminlte::page')

@section('content_header')
    <h1>Edit project</h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit project</li>
    </ol>
@stop

@section('content')
    {!! Form::model($project, ['method' => 'post','route' => ['admin.api.project.update', $project->id]]) !!}
    @include('backend.api.form')
    {!! Form::close() !!}
@endsection
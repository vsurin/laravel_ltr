@extends('backend.layouts.default')

@section('content_header')
    <h1>Edit project</h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit project</li>
    </ol>
@stop

@section('content')
    <div id="app">
        <update id="{{ $id  }}"></update>
    </div>
@endsection

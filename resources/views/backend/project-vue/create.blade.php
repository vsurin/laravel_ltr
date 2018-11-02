@extends('backend.layouts.default')

@section('content_header')
    <h1>Create project</h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Create project</li>
    </ol>
@stop

@section('content')
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>

    <div id="app">
        <create></create>
    </div>
@endsection

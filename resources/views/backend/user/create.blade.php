@extends('adminlte::page')

@section('content_header')
    <h1>Create user</h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Create user</li>
    </ol>
@stop

@section('content')
    {!! Form::open(array('route' => 'users.store','method'=>'POST', 'enctype' => 'multipart/form-data')) !!}
    @include('backend.user.form')
    {!! Form::close() !!}
@endsection
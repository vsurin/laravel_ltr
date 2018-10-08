@extends('adminlte::page')

@section('content_header')
    <h1>Edit user</h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit user</li>
    </ol>
@stop

@section('content')
    {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id], 'enctype' => 'multipart/form-data']) !!}
    @include('backend.user.form')
    {!! Form::close() !!}
@endsection
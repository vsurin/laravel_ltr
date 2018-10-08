@extends('adminlte::page')

@section('content_header')
    <h1>Show user</h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Show user</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div>
                <label>Name:</label>
                {{ $user->name }}
            </div>
            <div>
                <label>E-Mail:</label>
                {!! $user->email !!}
            </div>
            <div>
                <label>Role:</label>
                {!! $user->role !!}
            </div>
            @if($user->photo != '')
                <div>
                    <label>Photo:</label>
                    <div>
                        <img src="/upload/{{ $user->photo }}" height="350" />
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
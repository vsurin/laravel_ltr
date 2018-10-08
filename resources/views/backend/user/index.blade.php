@extends('adminlte::page')

@section('content_header')
    <h1>List users</h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
    </ol>
@stop

@section('content')
    <div class="row m-5">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('users.create') }}">Add User</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ $message }}
                </div>
            @endif
        </div>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>E-Mail</th>
            <th>Role</th>
            <th>Photo</th>
            <th width="280px">Action</th>
        </tr>

        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    @if($user->photo != '')
                        <img src="/upload/{{ $user->photo }}" height="50" />
                    @endif
                </td>
                <td>
                    <a class="btn btn-info" href="{{ route('users.show', $user->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}">Edit</a>

                    {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </table>
@endsection
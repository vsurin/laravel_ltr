@if (count($errors) > 0)
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="form-group">
            <label>Name:</label>
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>Email:</label>
            {{ Form::text('email', null, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            <label>Password:</label>
            {{ Form::text('password', '', ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            <label>Role:</label>
            {{ Form::select( 'role', ['user' => 'user', 'admin' => 'admin'], $user->role, ['class' => 'form-control'] ) }}
        </div>

        <div class="form-group">
            <label for="photo">Image:</label>
            {!! Form::file('photo') !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-right">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>

<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'editor' );
</script>
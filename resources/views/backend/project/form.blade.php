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
            <label>Title:</label>
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>descrription:</label>
            {{ Form::textarea('descrription', null, array('id'=>'editor')) }}
        </div>

        <div class="form-group">
            <label>Organization:</label>
            {{ Form::text('organization', null, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            <label>Start:</label>
            {{ Form::date('start', null, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            <label>End:</label>
            {{ Form::date('end', null, ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="form-group">
            <label>Link:</label>
            {{ Form::text('link', null, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            <label>Role:</label>
            {{ Form::select('role', $project->getRoles(), $project->role, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            <label>Type:</label>
            {{ Form::select('type', $project->getTypes(), $project->type, ['class' => 'form-control']) }}
        </div>

        <div>
            <label>Skisls:</label>
            <ul id="skills">
                @foreach($project->skills as $value)
                    <li>
                        <span>{{ $value->value }}</span>
                        <input type="hidden" name="skills[]" value="{{ $value->value }}">
                        <span class="buttonSkill">×</span>
                    </li>
                @endforeach
            </ul>
            <input type="text" value="" id="inputSkill" class="form-control">
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
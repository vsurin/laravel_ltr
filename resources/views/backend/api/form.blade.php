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
            <label>Role:</label>
            {{ Form::text('role', null, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            <label>Link:</label>
            {{ Form::text('link', null, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            <label>Type:</label>
            {{ Form::select('type', $project->getTypes(), ['class' => 'form-control']) }}
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
            <input type="text" value="" id="inputSkill">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-right">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'editor' );
</script>

<script type="text/javascript">
    (function($){
        $(function() {
            $('#inputSkill').on('keypress', function(e) {
                if(e.which === 13){
                    addSkill();

                    return false;
                }
            });

            $('#inputSkill').on('blur', function(e) {
                addSkill();
            });

            addEvent();

            function addSkill() {
                if ($('#inputSkill').val() != '') {
                    $('#skills').append(
                        $('<li>').append(
                            '<span>'+$('#inputSkill').val()+'</span>'+
                            '<input type="hidden" name="skills[]" value="'+$('#inputSkill').val()+'">'+
                            '<span class="buttonSkill">×</span>'
                        )
                    );
                }

                addEvent();

                $('#inputSkill').val('');
            }

            function addEvent(){
                $('.buttonSkill').on('click', function(){
                    $(this).parent().remove();
                });
            }
        });
    })(jQuery);
</script>

<style>
    .buttonSkill{
        content: "×";
        font-size: 17px;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        filter: alpha(opacity=20);
        opacity: .2;
        position: relative;
        top: 1px;
    }

    .buttonSkill:hover {
        color: #000;
        text-decoration: none;
        cursor: pointer;
        filter: alpha(opacity=50);
        opacity: .5;
    }
</style>
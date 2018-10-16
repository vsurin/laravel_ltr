<table class="table table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Organization</th>
        <th>Start</th>
        <th>End</th>
        <th>Role</th>
        <th>Link</th>
        <th>Type</th>
        <th width="280px">Action</th>
    </tr>
    </thead>
    <tbody>
        @if (count($projects) > 0)
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->organization }}</td>
                    <td>{{ $project->start }}</td>
                    <td>{{ $project->end }}</td>
                    <td>{{ $project->role }}</td>
                    <td>{{ $project->link }}</td>
                    <td>{{ $project->type }}</td>
                    <td>
                        <a class="btn btn-info" href="{{ route('projects.show', $project->id) }}">Show</a>
                        <a class="btn btn-primary" href="{{ route('projects.edit', $project->id) }}">Edit</a>

                        {!! Form::open(['method' => 'DELETE','route' => ['projects.destroy', $project->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach

        @else
            <tr><td colspan="9">Not found projects</td></tr>
        @endif
    </tbody>
    @if (count($projects) > 0)
        <tfoot>
            <tr>
                <td colspan="9">
                    {{ $projects->links() }}
                </td>
            </tr>
        </tfoot>
    @endif
</table>
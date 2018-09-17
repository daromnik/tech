@extends("layouts.main")

@section("content")

    <h1>{{ __("messages.list_projects") }}</h1>

    <p><a href="{{ route("projects.create") }}" class="btn btn-primary active" role="button" aria-pressed="true">{{ __("messages.add_project") }}</a></p>

    <table class="table table-hover">
        <thead class="thead-dark">
        <tr>
            <th scope="col">{{ __("messages.domain") }}</th>
            <th scope="col">{{ __("messages.queries") }}</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            <tr>
                <th>{{ $project->domain }}</th>
                <td>
                    <a href="{{ route("groups.show", ["id" => $project->id]) }}">
                        <i data-feather="list" title="{{ __("messages.edit") }}"></i>
                    </a>
                </td>
                <td>
                    <a href="{{ route("projects.edit", ["id" => $project->id]) }}">
                        <i data-feather="edit" title="{{ __("messages.edit") }}"></i>
                    </a>
                    <a href="{{ route("projects.destroy", ["id" => $project->id]) }}">
                        <i data-feather="x-square" title="{{ __("messages.delete") }}"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
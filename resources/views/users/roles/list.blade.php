@extends("layouts.main")

@section("content")

    <h1>{{ __("messages.list_roles") }}</h1>

    <p><a href="{{ route("roles.create") }}" class="btn btn-primary active" role="button" aria-pressed="true">{{ __("messages.add_role") }}</a></p>

    <table class="table table-sm table-hover">
        <thead class="thead-dark">
        <tr>
            <th class="col-6" scope="col">{{ __("messages.role") }}</th>
            <th class="col-5" scope="col">{{ __("messages.code") }}</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td>{{ $role->slug }}</td>
                <td class="text-center">
                    <a href="{{ route("roles.edit", ["id" => $role->id]) }}"><i data-feather="edit" title="{{ __("messages.edit") }}"></i></a>
                    <a href="{{ route("roles.destroy", ["id" => $role->id]) }}"><i data-feather="x-square" title="{{ __("messages.delete") }}"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
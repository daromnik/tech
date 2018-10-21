@extends("layouts.main")

@section("content")

    <h1>{{ __("messages.list_users") }}</h1>

    <p><a href="{{ route("users.create") }}" class="btn btn-primary active" role="button" aria-pressed="true">{{ __("messages.add_user") }}</a></p>

    <table class="table table-sm table-hover">
        <thead class="thead-dark">
        <tr>
            <th scope="col">{{ __("messages.name") }}</th>
            <th scope="col">{{ __("messages.email") }}</th>
            <th scope="col">{{ __("messages.role") }}</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <th>{{ $user->name }}</th>
                <td>{{ $user->email }}</td>
                <td>{{ $roles[$user->role_id] }}</td>
                <td>
                    <a href="{{ route("users.edit", ["id" => $user->id]) }}"><i data-feather="edit" title="{{ __("messages.edit") }}"></i></a>
                    <a href="{{ route("users.destroy", ["id" => $user->id]) }}"><i data-feather="x-square" title="{{ __("messages.delete") }}"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
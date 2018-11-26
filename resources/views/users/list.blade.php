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
                    <form action="{{ route("users.destroy", $user) }}" method="post">

                        {{ csrf_field() }}
                        {{ method_field("DELETE") }}

                        <a href="{{ route("users.edit", ["id" => $user->id]) }}"><i data-feather="edit" title="{{ __("messages.edit") }}"></i></a>
                        <button type="submit" class="btn btn-link p-0">
                            <i type="submit" data-feather="x-square" title="{{ __("messages.delete") }}"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
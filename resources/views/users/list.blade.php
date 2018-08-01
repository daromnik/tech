@extends("layouts.main")

@section("content")

    <h1>Список пользователей</h1>

    <p><a href="{{ route("userAdd") }}" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Добавить пользователя</a></p>

    <ul class="list-group">
        @foreach($users as $user)
            <li class="list-group-item">
                <p>{{ $user->first_name }} {{ $user->last_name }} - {{ $user->roles->first()->name }}</p>
                <p>{{ $user->email }}</p>
                <p><a href="{{ route("userUpdate", ["id" => $user->id]) }}" class="btn btn-primary" role="button" aria-pressed="true">Редактировать</a></p>
            </li>
        @endforeach
    </ul>


@endsection
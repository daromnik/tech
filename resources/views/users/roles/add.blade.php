@extends("layouts.main")

@section("content")

    <h1>
        @if(isset($role))
            {{ __("messages.edit_role") }}
        @else
            {{ __("messages.add_role") }}
        @endif
    </h1>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif

    @if (session('err'))
        <div class="alert alert-danger" role="alert">
            {{ session('err') }}
        </div>
    @endif

    <form method="post">

        {{ csrf_field() }}

        <div class="form-group">
            <label for="role-name">{{ __("messages.title") }}</label>
            <input type="text" value="{{ $role->name ?? old("name") }}" class="form-control" name="name" placeholder="{{ __("messages.title") }}">
        </div>

        <div class="form-group">
            <label for="role-slug">{{ __("messages.code") }}</label>
            <input type="text" value="{{ $role->slug ?? old("slug") }}" class="form-control" name="slug" placeholder="{{ __("messages.code") }}">
        </div>

        <div class="form-group">
            <label>{{ __("messages.permissions") }}</label><br>
            @foreach($permissions as $name => $path)
                @if($name != "login" && $name != "logout")
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="permission-{{ $name }}" name="permissions[{{ $path }}]" @if(isset($role) && isset($role->permissions[$path])) checked @endif>
                        <label class="custom-control-label" for="permission-{{ $name }}">{{ $name }}</label>
                    </div>
                @endif
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">{{ __("messages.submit") }}</button>
        <a href="{{ route("roleList") }}" class="btn btn-secondary active" role="button" aria-pressed="true">{{ __("messages.cancel") }}</a>

    </form>

@endsection
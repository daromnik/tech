@extends("layouts.main")

@section("content")

    @if(isset($user))
        <h1>{{ __("messages.edit_user") }}</h1>
    @else
        <h1>{{ __("messages.add_user") }}</h1>
    @endif

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
            <label for="contact-name">{{ __("messages.first_name") }}</label>
            <input type="text" value="{{ $user->first_name ?? old("first_name") }}" class="form-control" name="first_name" id="first_name" placeholder="{{ __("messages.first_name") }}">
        </div>

        <div class="form-group">
            <label for="contact-email">{{ __("messages.last_name") }}</label>
            <input type="text" value="{{ $user->last_name ?? old("last_name") }}" class="form-control" name="last_name" id="last_name" placeholder="{{ __("messages.last_name") }}">
        </div>

        <div class="form-group">
            <label for="contact-email">{{ __("messages.email") }}</label>
            <input type="email" value="{{ $user->email ?? old("email") }}" class="form-control" name="email" id="email" placeholder="{{ __("messages.email") }}">
        </div>

        <div class="form-group">
            <label for="contact-role">{{ __("messages.role") }}</label>
            <select class="form-control" id="contact-role" name="role">
                <option>{{ __("messages.choose_user_role") }}</option>
                @foreach($roles as $role)
                    <option value="{{ $role->getRoleId() }}" @if(isset($userRole) && $userRole == $role->getRoleId()) selected @endif>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="contact-email">{{ __("messages.password") }}</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="{{ __("messages.password") }}">
        </div>

        <div class="form-group">
            <label for="contact-email">{{ __("messages.password_confirmation") }}</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="{{ __("messages.password_confirmation") }}">
        </div>

        <button type="submit" class="btn btn-primary">{{ __("messages.submit") }}</button>

    </form>

@endsection
@extends("layouts.main")

@section("content")

    <h1>
        @if(isset($user))
            {{ __("messages.edit_user") }}
        @else
            {{ __("messages.add_user") }}
        @endif
    </h1>

    @include("layouts.error")

    <form method="post" action="@if(isset($user)){{ route("users.update", $user) }}@else{{ route("register") }}@endif">

        @csrf

        @if(isset($user))
            {{ method_field("PUT") }}
        @endif

        <div class="form-group">
            <label for="contact-name">{{ __("messages.first_name") }}</label>
            <input type="text" value="{{ $user->name ?? old("name") }}" class="form-control" name="name" id="name" placeholder="{{ __("messages.first_name") }}">
        </div>

        <div class="form-group">
            <label for="contact-email">{{ __("messages.email") }}</label>
            <input type="email" value="{{ $user->email ?? old("email") }}" class="form-control" name="email" id="email" placeholder="{{ __("messages.email") }}">
        </div>

        <div class="form-group">
            <label for="contact-role">{{ __("messages.role") }}</label>
            <select class="form-control" id="contact-role" name="role_id" required>
                <option>{{ __("messages.choose_user_role") }}</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" @if(isset($user) && $user->role_id == $role->id) selected @endif>{{ $role->name }}</option>
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
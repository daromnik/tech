@extends("layouts.index")

@section("content")

    <form class="form-signin" method="post" action="{{ route('auth') }}">

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
            @endforeach
        @endif

        @if(session('err'))
            <div class="alert alert-warning" role="alert"> {{ session('err') }}</div>
        @endif

        @csrf

        <img class="mb-4" src="https://bootstrap-4.ru/docs/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">

        <h1 class="h3 mb-3 font-weight-normal">{{ __("messages.please_sign_in") }}</h1>

        <label for="inputEmail" class="sr-only">{{ __("messages.email") }}</label>

        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="{{ __("messages.email") }}" required autofocus>

        <label for="inputPassword" class="sr-only">{{ __("messages.password") }}</label>

        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="{{ __("messages.password") }}" required>

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me" name="remember"> {{ __("messages.remember_me") }}
            </label>
        </div>

        <button class="btn btn-lg btn-primary btn-block" type="submit">{{ __("messages.signin") }}</button>

    </form>

@endsection
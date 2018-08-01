@extends("layouts.main")

@section("content")

    @if(isset($user))
        <h1>Редкатировать пользователя</h1>
    @else
        <h1>Добавить нового пользователя</h1>
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
            <label for="contact-name">First name</label>
            <input type="text" value="{{ $user->first_name ?? old("first_name") }}" class="form-control" name="first_name" id="first_name" placeholder="First name">
        </div>

        <div class="form-group">
            <label for="contact-email">Last name</label>
            <input type="text" value="{{ $user->last_name ?? old("last_name") }}" class="form-control" name="last_name" id="last_name" placeholder="Last name">
        </div>

        <div class="form-group">
            <label for="contact-email">Email</label>
            <input type="email" value="{{ $user->email ?? old("email") }}" class="form-control" name="email" id="email" placeholder="Email">
        </div>

        <div class="form-group">
            <label for="contact-role">Role</label>
            <select class="form-control" id="contact-role" name="role">
                <option>Choose user's role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->getRoleId() }}" @if(isset($userRole) && $userRole == $role->getRoleId()) selected @endif>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="contact-email">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>

        <div class="form-group">
            <label for="contact-email">Password Confirmation</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Password Confirmation">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>

    </form>

@endsection
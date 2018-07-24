@extends("layouts.main")

@section("content")

    <h1>Добавить нового пользователя</h1>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <form method="post">

        {{ csrf_field() }}

        <div class="form-group">
            <label for="contact-name">First name</label>
            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First name">
        </div>

        <div class="form-group">
            <label for="contact-email">Last name</label>
            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last name">
        </div>

        <div class="form-group">
            <label for="contact-email">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
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
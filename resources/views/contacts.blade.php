@extends("layouts.main")

@section("content")
    <h1>Контакты</h1>

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
            <label for="contact-name">Name</label>
            <input type="text" class="form-control" name="name" id="contact-name" aria-describedby="emailHelp" placeholder="Enter name">
        </div>

        <div class="form-group">
            <label for="contact-email">Email</label>
            <input type="email" class="form-control" name="email" id="contact-email" aria-describedby="emailHelp" placeholder="Enter email">
        </div>

        <div class="form-group">
            <label for="contact-text">Comment</label>
            <textarea name="text" class="form-control" id="contact-text" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>

    </form>

    <ul class="list-group list-group-flush">

        @foreach($allContacts as $contact)
            <li class="list-group-item">
                {{ $contact->name }}<br>
                {{ $contact->email }}<br>
                {{ $contact->text }}
            </li>
        @endforeach
    </ul>

@endsection
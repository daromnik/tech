@extends("layouts.main")

@section("content")

    <h1>{{ __("messages.indicators") }}</h1>

    <p><button type="button" data-toggle="modal" data-target="#addIndicator-0" class="btn btn-primary">{{ __("messages.add_indicator") }}</button></p>

    @include("layouts.error")

    @if (Sentinel::inRole("admin"))
        FUCK
    @endif



    @include("projects.indicators.add", ["indicator" => []])

@endsection
@extends("layouts.main")

@section("content")

    <h1>{{ __("messages.settings") }}</h1>

    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#search-engine" role="tab" aria-controls="search_engine" aria-selected="true">
                {{ __("messages.search_engine") }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#proxy" role="tab" aria-controls="proxy" aria-selected="false">
                {{ __("messages.proxy") }}
            </a>
        </li>
    </ul>

    <div class="tab-content pt-3">

        <div class="tab-pane fade show active" id="search-engine" role="tabpanel" aria-labelledby="search-engine-tab">

        </div>

        <div class="tab-pane fade" id="proxy" role="tabpanel" aria-labelledby="proxy-tab">

        </div>

    </div>

@endsection

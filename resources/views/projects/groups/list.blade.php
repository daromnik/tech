@extends("layouts.main")

@section("content")

    <h1>{{ __("messages.list_queries") }}</h1>

    <p><button type="button" data-toggle="modal" data-target="#addGroup-0" class="btn btn-primary">{{ __("messages.add_group") }}</button></p>

    @foreach($groups as $group)
        <table class="table table-hover">
            <thead class="thead-dark">
            <tr>
                <th scope="col">{{ $group->name }}</th>
                <th scope="col">{{ __("messages.url_promoted_page") }}</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">H1</th>
                <th scope="col">{{ __("messages.cost") }}</th>
                <th scope="col">{{ __("messages.value_request") }}</th>
                <th scope="col">
                    <form action="{{ route("groups.destroy", $group) }}" method="post">

                        {{ csrf_field() }}
                        {{ method_field("DELETE") }}

                        <a href="#" data-toggle="modal" data-target="#addGroup-{{ $group->id }}" class="btn btn-link p-0">
                            <i data-feather="edit" title="{{ __("messages.edit") }}"></i>
                        </a>
                        <button type="submit" class="btn btn-link p-0">
                            <i type="submit" data-feather="x-square" title="{{ __("messages.delete") }}"></i>
                        </button>
                    </form>
                </th>
            </tr>
            </thead>

            <tbody>
            <?/*@foreach($groups as $group)
                <tr>
                    <th></th>
                    <td></td>
                </tr>
            @endforeach*/?>
            </tbody>
        </table>

        @include("projects.groups.add", ["project" => $project, "group" => $group])

    @endforeach

    @include("projects.groups.add", ["project" => $project, "group" => []])

@endsection
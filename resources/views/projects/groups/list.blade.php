@extends("layouts.main")

@section("content")

    <h1>{{ __("messages.list_queries") }}</h1>

    <p><button type="button" data-toggle="modal" data-target="#addGroup-0" class="btn btn-primary">{{ __("messages.add_group") }}</button></p>

    @include("layouts.error")

    @foreach($groups as $group)
        <table class="table table-hover table-sm">
            <thead class="thead-dark">
            <tr>
                <th scope="col" class="align-middle">{{ $group->name }}</th>
                <th scope="col" class="align-middle">URL</th>
                <th scope="col" class="align-middle">Title</th>
                <th scope="col" class="align-middle">Description</th>
                <th scope="col" class="align-middle">H1</th>
                <th scope="col" class="align-middle">{{ __("messages.cost") }}</th>
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
            @foreach($group->queries()->get() as $query)
                <tr>
                    <th>{{ $query->name }}</th>
                    <td>{{ $query->url }}</td>
                    <td>{{ $query->title }}</td>
                    <td>{{ $query->description }}</td>
                    <td>{{ $query->h1 }}</td>
                    <td>{{ $query->cost }}</td>
                    <td>{{ $query->value_query }}</td>
                    <td></td>
                </tr>
            @endforeach
                <tr class="table-secondary">
                    <th colspan="8" class="pl-2">
                        <form action="{{ route("loadQueries") }}" method="post" enctype="multipart/form-data">

                            {{  csrf_field() }}
                            <input type="hidden" name="group_id" value="{{ $group->id }}">

                            <div class="form-row">
                                <div class="custom-file col-11">
                                    <input type="file" class="custom-file-input" id="queryFile" name="queryFile">
                                    <label class="custom-file-label" for="queryFile">File with Queries (xls, xlsx)</label>
                                </div>

                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Load</button>
                                </div>
                            </div>
                        </form>
                    </th>
                </tr>
            </tbody>
        </table>

        @include("projects.groups.add", ["project" => $project, "group" => $group])

    @endforeach

    @include("projects.groups.add", ["project" => $project, "group" => []])

@endsection
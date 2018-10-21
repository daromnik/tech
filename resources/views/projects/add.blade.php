@extends("layouts.main")

@section("content")

    <h1>
        @if(isset($project))
            {{ __("messages.edit_project") }}
        @else
            {{ __("messages.add_project") }}
        @endif
    </h1>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <form method="post" action="@if(isset($project)){{ route("projects.update", $project) }}@else{{ route("projects.store") }}@endif">

        @csrf

        @if(isset($project))
            {{ method_field("PUT") }}
        @endif

        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">
                    {{ __("messages.general") }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#technical" role="tab" aria-controls="technical" aria-selected="false">
                    {{ __("messages.technical") }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#accounting" role="tab" aria-controls="accounting" aria-selected="false">
                    {{ __("messages.accounting") }}
                </a>
            </li>
        </ul>
        <div class="tab-content pt-3">
            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">

                <div class="form-group row">
                    <div class="col-sm-2">{{ __("messages.active") }}</div>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" name="active" @if(!empty($project->active)) checked @endif type="checkbox">
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">{{ __("messages.domain") }}</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{ $project->domain ?? old("domain") }}" name="domain" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-2">{{ __("messages.is_www") }}</div>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" name="is_www" @if(!empty($project->is_www)) checked @endif type="checkbox">
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-2">{{ __("messages.is_https") }}</div>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" name="is_https" @if(!empty($project->is_https)) checked @endif type="checkbox">
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-2">{{ __("messages.out_total_visibility") }}</div>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" name="out_total_visibility" type="checkbox">
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">{{ __("messages.report_day") }}</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{ $project->report_day ?? old("report_day") }}" name="report_day" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">{{ __("messages.level") }}</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{ $project->level ?? old("level") }}" name="level" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">{{ __("messages.manager") }}</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="manager_id" id="exampleFormControlSelect1">
                            <option></option>
                            @foreach($roleUsers["manager"] as $manager)
                                <option value="{{ $manager->id }}" @if(isset($project) && $project->manager_id == $manager->id) selected @endif>
                                    {{ $manager->first_name }} {{ $manager->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">{{ __("messages.optimizer") }}</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="optimizer_id" id="exampleFormControlSelect1">
                            <option></option>
                            @foreach($roleUsers["optimizer"] as $optimizer)
                                <option value="{{ $optimizer->id }}" @if(isset($project) && $project->optimizer_id == $optimizer->id) selected @endif>
                                    {{ $optimizer->first_name }} {{ $optimizer->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">{{ __("messages.client") }}</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="client_id" id="exampleFormControlSelect1">
                            <option></option>
                            @foreach($roleUsers["client"] as $client)
                                <option value="{{ $client->id }}" @if(isset($project) && $project->client_id == $client->id) selected @endif>
                                    {{ $client->first_name }} {{ $client->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <div class="tab-pane fade" id="technical" role="tabpanel" aria-labelledby="technical-tab">

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">{{ __("messages.ga_acount") }}</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{ $project->ga_acount ?? old("ga_acount") }}" name="ga_acount" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">{{ __("messages.ga_count_number") }}</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{ $project->ga_count_number ?? old("ga_count_number") }}" name="ga_count_number" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">{{ __("messages.ga_profile_id") }}</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{ $project->ga_profile_id ?? old("ga_profile_id") }}" name="ga_profile_id" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">{{ __("messages.bitrix24_project_id") }}</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{ $project->bitrix24_project_id ?? old("bitrix24_project_id") }}" name="bitrix24_project_id" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">{{ __("messages.link_bitrix24") }}</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{ $project->link_bitrix24 ?? old("link_bitrix24") }}" name="link_bitrix24" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">{{ __("messages.link_y_webmaster") }}</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{ $project->link_y_webmaster ?? old("link_y_webmaster") }}" name="link_y_webmaster" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">{{ __("messages.link_g_search_cosole") }}</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{ $project->link_g_search_cosole ?? old("link_g_search_cosole") }}" name="link_g_search_cosole" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">{{ __("messages.link_ga") }}</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{ $project->link_ga ?? old("link_ga") }}" name="link_ga" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">{{ __("messages.logo") }}</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{ $project->logo ?? old("logo") }}" name="logo" class="form-control">
                    </div>
                </div>

            </div>

            <div class="tab-pane fade" id="accounting" role="tabpanel" aria-labelledby="accounting-tab">

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">{{ __("messages.monthly_payment") }}</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{ $project->monthly_payment ?? old("monthly_payment") }}" name="monthly_payment" class="form-control">
                    </div>
                </div>

            </div>
        </div>

        <button type="submit" class="btn btn-primary">{{ __("messages.submit") }}</button>

    </form>

@endsection
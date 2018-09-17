
<div class="modal fade" id="addGroup-{{ $group->id ?? "0" }}" tabindex="-1" role="dialog" aria-labelledby="addGroupLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __("messages.add_group") }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ empty($group) ? route("groups.store") : route("groups.update", $group) }}">

                    {{ csrf_field() }}

                    {{ !empty($group) ? method_field("put") : "" }}

                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">{{ __("messages.name") }}:</label>
                        <input type="text" class="form-control" id="recipient-name" name="name" value="{{ $group->name ?? "" }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary float-right">{{ __("messages.submit") }}</button>
                </form>
            </div>
        </div>
    </div>
</div>


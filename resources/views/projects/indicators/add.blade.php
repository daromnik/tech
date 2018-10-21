
<div class="modal fade" id="addIndicator-{{ $indicator->id ?? "0" }}" tabindex="-1" role="dialog" aria-labelledby="addGroupLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __("messages.add_indicator") }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ empty($indicator) ? route("indicators.store") : route("indicators.update", $indicator) }}">

                    {{ csrf_field() }}

                    {{ !empty($indicator) ? method_field("put") : "" }}

                    <div class="form-group">
                        <label for="indicator-name" class="col-form-label">{{ __("messages.name") }}:</label>
                        <input type="text" class="form-control" id="indicator-name" name="name" value="{{ $indicator->name ?? "" }}" required>
                    </div>
                    <div class="form-group">
                        <label for="indicator-class" class="col-form-label">{{ __("messages.class") }}:</label>
                        <input type="text" class="form-control" id="indicator-class" name="class" value="{{ $indicator->class ?? "" }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary float-right">{{ __("messages.submit") }}</button>
                </form>
            </div>
        </div>
    </div>
</div>


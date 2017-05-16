<div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Activiteit toevoegen</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('activity.store') }}" id="form" method="POST" class="form-horizontal">
                    {{ csrf_field() }} {{-- CSRF FIELD --}}

                    <div class="form-group">
                        <label class="control-label col-md-3">Titel: <span class="text-danger">*</span></label>

                        <div class="col-md-9">
                            <input type="text" name="title" value="" class="form-control" placeholder="Titel activiteit">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Datum: <span class="text-danger">*</span></label>

                        <div class="col-md-5">
                            <input type="text" name="activiteit_datum" value="" value="" placeholder="Activiteit datum." class="form-control">
                        </div>

                        <div class="col-md-2">
                            <input type="text" name="start_hour" value="" class="form-control" placeholder="start. bv. 00:00">
                        </div>

                        <div class="col-md-2">
                            <input type="text" name="end_hour" value="" class="form-control" placeholder="eind. bv. 00:00">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="groep" class="control-label col-md-3">Groep: <span class="text-danger">*</span></label>

                        <div class="col-md-9">
                            <select name="group_id" class="form-control">
                                <option value="">-- Selecteer de groep --</option>

                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Status: <span class="text-danger">*</span></label>

                        <div class="col-md-9">
                            <select name="status" class="form-control">
                                <option value="">-- Selecteer status --</option>
                                <option value="0">Klad versie</option>
                                <option value="1">Publiceer</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Beschrijving: <span class="text-danger">*</span></label>

                        <div class="col-md-9">
                            <textarea name="description" class="form-control" rows="8" placeholder="Beschrijving van de activiteit"></textarea>
                            <span class="help-block"><small><i>(Dit veld is markdown ondersteund.)</i></small></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="form" class="btn btn-success"><span class="fa fa-check" aria-hidden="true"></span> Toevoegen</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close" aria-hidden="true"></span> Sluiten</button>
            </div>
        </div>
    </div>
</div>
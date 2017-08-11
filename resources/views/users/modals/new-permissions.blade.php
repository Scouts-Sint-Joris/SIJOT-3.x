<!-- Modal -->
<div class="modal fade" id="create-permissions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Toevoegen machteging</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('permissions.store') }}" class="form-horizontal" method="post" id="machteging">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Naam: <span class="text-danger">*</span>
                        </label>

                        <div class="col-md-9">
                            <input type="text" class="form-control" name="name" placeholder="Naam van de machteging.">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">
                            Beschrijving: <span class="text-danger">*</span>
                        </label>

                        <div class="col-md-9">
                            <textarea name="description" placeholder="Korte beschrijving v/d permissie." rows="5" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">
                            Verwijzing groep: {{-- <span class="text-danger">*</span> --}}
                        </label>

                        <div class="col-md-9">
                            <select name="roles" class="form-control" multiple>
                                @foreach ($roles as $role) {{-- Loop through the permissions. --}}
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach {{-- End loop --}}
                            </select>
                            <small class="help-block">* Hou uw CTRL toets ingedrukt om meerdere waarde te selecteren.</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" form="machteging">
                    <span class="fa fa-check" aria-hidden="true"></span> Toevoegen
                </button>

                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <span class="fa fa-undo" aria-hidden="true"></span> Sluiten
                </button>
            </div>
        </div>
    </div>
</div>
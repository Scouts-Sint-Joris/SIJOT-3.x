<div class="modal fade" id="create-role" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Toevoegen gebruikersgroep.</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('roles.store') }}" method="POST" class="form-horizontal" id="role">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Naam: <span class="text-danger">*</span>
                        </label>

                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Naam v/d gebruikersgroep" name="name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">
                            Beschrijving: <span class="text-danger">*</span>
                        </label>

                        <div class="col-md-9">
                            <textarea name="description" class="form-control" placeholder="Een kort omschrijving van de gebruikersgroep." rows="5"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">
                            Toewijzing: {{-- <span class="text-danger">*</span> --}}
                        </label>

                        <div class="col-md-9">
                            <select name="users[]" class="form-control" multiple>
                                @foreach ($users as $users) {{-- Loop through the useres. --}}
                                    <option value="{{ $user->id }}"> {{ $user->name }} </option>
                                @endforeach
                            </select>
                            <small class="help-block">* Hou uw CTRL toets ingedrukt om meerdere waarde te selecteren.</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" form="role">
                    <span class="fa fa-check" aria-hidden="true"></span> Toevoegen
                </button>

                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <span class="fa fa-undo" aria-hidden="true"></span> Annuleren
                </button>
            </div>
        </div>
    </div>
</div>
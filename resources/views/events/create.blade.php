<div id="create-event" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Nieuw evenement</h4>
            </div>
            <div class="modal-body">
                <form action="" class="form-horizontal" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="author_id" value="{{ auth()->user()->id }}">

                    <div class="form-group">
                        <label class="control-label col-sm-3">Naam: <span class="text-danger">*</span></label>

                        <div class="col-sm-9">
                            <input type="text" name="title" placeholder="Titel evenement" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Status: <span class="text-danger">*</span></label>

                        <div class="col-md-9">
                            <select name="status" class="form-control">
                                <option value="">-- Selecteer de status --</option>
                                <option value="0">Klad versie</option>
                                <option value="1">Publicatie</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Start datum: <span class="text-danger">*</span></label>

                        <div class="col-md-7">
                            <input type="date" class="form-control" name="start_date">
                        </div>

                        <div class="col-md-2">
                            <input type="time" class="form-control" name="start_hour">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Eind datum: <span class="text-danger">*</span></label>

                        <div class="col-md-7">
                            <input type="date" class="form-control" name="end_date">
                        </div>

                        <div class="col-sm-2">
                            <input type="time" class="form-control" name="end_hour">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Beschrijving <span class="text-danger">*</span></label>

                        <div class="col-md-9">
                            <textarea name="description" class="form-control" placeholder="Evenement beschrijving. Vergeet ook niet de eventueel schrijvings prijs. Want men kan digitaal inschrijven." rows="10"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><span class="fa fa-check" aria-hidden="true"></span> Aanmaken</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close" aria-hidden="true"></span> Sluiten</button>
            </div>
        </div>

    </div>
</div>
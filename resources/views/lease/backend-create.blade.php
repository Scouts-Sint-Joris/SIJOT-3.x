<div class="modal fade" id="create-lease" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Verhuring toevoegen</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('lease.store') }}" id="lease-create" method="POST" class="form-horizontal">
                    {{ csrf_field() }} {{-- CSRF FIELD --}}

                    <div class="form-group">
                        <label class="control-label col-md-3">
                            Start datum: <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                            <input type="date" class="form-control" name="start_datum" placeholder="Start dtum">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">
                            Eind datum: <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                            <input type="date" class="form-control" name="eind_datum" placeholder="Eind datum">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">
                            Status: <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                            <select name="status_id" class="form-control">
                                <option value="">-- Selecteer de status --</option>
                                <option value="1">Nieuwe aanvraag</option>
                                <option value="2">Optie</option>
                                <option value="3">Bevestigd</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">
                            Groepsnaam: <span class="text-danger">*</span>
                        </label>

                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Naam van de groep/persoon" name="groeps_naam">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">
                            Email: <span class="text-danger">*</span>
                        </label>

                        <div class="col-md-9">
                            <input type="email" placeholder="Email v\d contact persoon" name="contact_email" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">
                            Tel. nummer:
                        </label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="tel. nummer v\d contact persoon" name="tel_nummer">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="lease-create" class="btn btn-success"><span class="fa fa-check" aria-hidden="true"></span> Toevoegen</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close" aria-hidden="true"></span> Sluiten</button>
            </div>
        </div>
    </div>
</div>
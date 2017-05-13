<!-- Modal -->
<div class="modal fade" id="create-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Nieuwe gebruiker.</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" id="create" action="">
                    {{ csrf_field() }} {{-- CSRF token --}}

                    <div class="form-group">
                        <label class="control-label col-md-3">
                            Naam: <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                            <input class="form-control" name="name" placeholder="Naam" type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">
                            E-mail adres: <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                            <input type="email" class="form-control" name="email" placeholder="E-mail adres">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Wachtwoord: <span class="text-danger">*</span></label>

                        <div class="col-md-9">
                            <input type="password" class="form-control" name="password" placeholder="Wachtwoord">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Bevestiging: <span class="text-danger">*</span></label>

                        <div class="col-md-9">
                            <input type="password" class="form-control" placeholder="Wachtwoord bevestiging" name="password_confirmation">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button form="create" type="submit" class="btn btn-success"><span class="fa fa-check"></span> Aanmaken</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close" aria-hidden="true"></span> Sluiten</button>
            </div>
        </div>
    </div>
</div>

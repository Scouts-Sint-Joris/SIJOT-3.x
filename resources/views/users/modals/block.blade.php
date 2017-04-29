{{-- User block modal. --}}
<div class="modal fade" id="block-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Blokkeer een gebruiker.</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" id="form" action="{{ route('users.block') }}">
                    {{ csrf_field() }} {{-- Form security check --}}
                    <input type="hidden"  name="id" value="">

                    <div class="form-group">
                        <label class="control-label col-md-3">Naam:</label>

                        <div class="col-md-9">
                            <input class="form-control" name="name" value="" placeholder="Gebruikersnaam" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Eind datum: <span class="text-danger">*</span></label>

                        <div class="col-md-9">
                            <input type="date" name="eind_datum" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Reden: <span class="text-danger">*</span></label>

                        <div class="col-md-9">
                            <textarea name="reason" rows="7" class="form-control" placeholder="Reden tot blokkering"></textarea>
                            <span class="help-block"><small><i>(Dit veld ondersteund markdown.)</i></small></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="form" class="btn btn-success"><span class="fa fa-check" aria-hidden="true"></span> Blokkeren</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close" aria-hidden="true"></span> Sluiten</button>
            </div>
        </div>
    </div>
</div>
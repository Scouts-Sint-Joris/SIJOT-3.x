<div class="modal fade" id="reset-pass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Wachtwoord vergeten.</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" id="reset" method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-3 control-label">E-Mail Adress: <span class="text-danger">*</span></label>

                        <div class="col-md-9">
                            <input id="email" placeholder="Uw email adres" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="reset" class="btn btn-success"><span class="fa fa-check" aria-hidden="true"></span> Reset </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal"><span class="fa fa-close" aria-hidden="true"></span> Sluiten</button>
            </div>
        </div>
    </div>
</div>
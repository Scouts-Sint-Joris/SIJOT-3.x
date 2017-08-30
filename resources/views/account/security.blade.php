<div class="tab-pane fade in" id="security">
    <div class="box"> {{-- Default box --}}
        <div class="box-header with-border">
            <h3 class="box-title">Account informatie</h3>
        </div>

        <div class="box-body">
            <form action="{{ route('account.security') }}" method="POST" class="form-horizontal">
                {{-- CSRF TOKEN --}}
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="password" class="control-label col-sm-2">
                        Wachtwoord: <span class="text-danger">*</span>
                    </label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="password" name="assword" placeholder="Wachtwoord">
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm" class="control-label col-sm-2">
                        Bevestig wachtwoord: <span class="text-danger">*</span>
                    </label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="confirm" name="password_confirmation" placeholder="Wachtwoord bevestiging">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                        <button type="submit" class="btn btn-sm btn-flat btn-success"><span class="fa fa-check" aria-hidden="true"></span> Wijzigen</button>
                        <button type="reset" class="btn btn-danger btn-flat btn-sm"><span class="fa fa-undo" aria-hidden="true"></span> Reset</button>
                    </div>
                </div>
            </form>
        </div> {{-- /.box-body --}}
    </div> {{-- /.box --}}
</div>
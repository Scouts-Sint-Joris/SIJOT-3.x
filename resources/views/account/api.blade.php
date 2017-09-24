<div class="tab-pane fade in" id="api">
    <div class="box box-success collapsed-box">
        <div class="box-header with-border">
            <h4 class="box-title">Sleutel toevoegen.</h4>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body" style="display: block;"> {{-- Display none for the collapsed box. --}}
            <form action="{{ route('api.key.create') }}" method="POST" class="form-horizontal">
                {{ csrf_field() }} {{-- CSRF form protection --}}

                <div class="form-group">
                    <div class="col-md-12 {{ $errors->has('service') ? 'has-error' : '' }}">
                        <input type="text" name="service" class="form-control" placeholder="Naam van je applicatie.">

                        @if ($errors->has('service'))
                            <small class="help-block">{{ $errors->first('service') }}</small>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-sm btn-success">
                            <span class="fa fa-check" aria-hidden="true"></span> Toevoegen
                        </button>

                        <button class="btn btn-sm btn-link" type="reset">
                            <span class="fa fa-undo" aria-hidden="true"></span> Annuleren
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ($user->apiKeys()->count() === 0)
        <div class="alert alert-info alert-important">
            <strong><span class="fa fa-info-circle"></span> Info:</strong>
            U heeft nog geen API sleutels aangemaakt.
        </div>
    @else
        <div class="box box-warning"> {{-- Default box --}}
            <div class="box-header with-border">
                <h3 class="box-title">API sleutels</h3>
            </div>

            <div class="box-body">
                @php $keys = $user->apiKeys()->paginate(10) @endphp

                <table class="table table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Service:</th>
                            <th colspan="2">Key:</th> {{-- Colspan 2 needed for the delete function. --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($keys as $key) {{-- Loop through authencated user api keys. --}}
                            <tr>
                                <td><strong>#{{ $key->id }}</strong></td>
                                <td>{{ $key->service }}</td>
                                <td><code>{{ $key->key }}</code></td>
                                <td class="text-center">
                                    <a href="{{-- route('api.key.delete', $key) --}}" class="label label-danger">Verwijder</a>
                                </td>
                            </tr>
                        @endforeach {{-- END loop--}}
                    </tbody>
                </table>
            </div> {{-- /.box-body --}}
        </div> {{-- /.box --}}
    @endif
</div>
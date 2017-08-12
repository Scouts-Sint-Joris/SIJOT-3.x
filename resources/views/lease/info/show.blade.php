@extends('layouts.backend')

@section('title')
    <h1> Verhurings info <small>#{{ $lease->id }}: {{ $lease->groeps_naam }}</small></h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('backend') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('lease.backend') }}">Verhuur</a></li>
        <li class="active">#{{ $lease->id }}: {{ $lease->groeps_naam }}</li>
    </ol>
@endsection

@section('content')
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab"><span class="fa fa-info-circle" aria-hidden="true"></span> Info</a></li>
            <li>
                <a href="#tab_2" data-toggle="tab">
                    <span class="fa fa-file-text-o"></span> Notities

                    @if ($lease->notitions()->count() > 0)
                        <small style="margin-left: 3px;" class="text-danger"><i>({{ $lease->notitions->count() }})</i></small></span>
                    @endif
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1"> {{-- START info tab --}}
                <div class="row">
                    <div class="col-md-8">
                        <form action="{{ route('lease.info.update', $lease) }}" method="POST" class="form-horizontal">
                            {{ csrf_field() }} {{-- Needed for the form CSRF protection. --}}
                            <input type="hidden" name="status_id" value="{{ $lease->status_id }}">

                            <fieldset>
                                <legend>Gegevens verhuurder (van de aanvraag):</legend>

                                <div class="col-md-6 form-group {{ $errors->has('groeps_naam') ? 'has-error' : '' }}">
                                    <label class="control-label col-md-4">Groep/Persoon: <span class="text-danger">*</span></label>

                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="groeps_naam" value="{{ $lease->groeps_naam }}">
                                        @if ($errors->has('groeps_naam')) <small class="help-block">{{ $errors->first('groeps_naam') }}</small> @endif
                                    </div>
                                </div>

                                <div class="col-md-6 form-group {{ $errors->has('start_datum') ? 'has-error' : '' }}">
                                    <label class="control-label col-md-4">Start datum: <span class="text-danger">*</span></label>

                                    <div class="col-md-8">
                                        <input type="text" name="start_datum" class="form-control" value="{{ $lease->start_datum->format('d/m/Y') }}">
                                        @if ($errors->has('start_datum')) <small class="help-block">{{ $errors->first('start_datum') }}</small> @endif
                                    </div>
                                </div>

                                <div class="col-md-6 form-group {{ $errors->has('contact_email') ? 'has-error' : '' }}">
                                    <label class="control-label col-md-4">Email adres: <span class="text-danger">*</span></label>

                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="contact_email" value="{{ $lease->contact_email }}">
                                        @if ($errors->has('contact_email')) <small class="help-block">{{ $errors->first('contact_email')}}</small> @endif
                                    </div>
                                </div>

                                <div class="col-md-6 form-group {{ $errors->has('eind_datum') ? 'has-error' : '' }}">
                                    <label class="control-label col-md-4">Eind datum: <span class="text-danger">*</span></label>

                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="eind_datum" value="{{ $lease->eind_datum->format('d/m/Y') }}">
                                        @if ($errors->has('eind_datum')) <small class="help-block">{{ $errors->first('eind_datum') }}</small> @endif
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="control-label col-md-4">Tel. nummer:</label>

                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="tel_nummer" value="{{ $lease->tel_nummer }}">
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Gegevens lokalen:</legend>

                                <div class="col-md-6 form-group">
                                    <label class="control-label col-md-4">Opener:</label>

                                    <div class="col-md-8">
                                        <select name="opener_id" class="form-control">
                                            <option value="">-- Geen persoon geslecteerd --</option>

                                            @foreach ($persons as $person2) {{-- Loop through the users --}}
                                                <option value="{{ $person2->id }}">{{ $person2->name }}</option>
                                            @endforeach {{-- End loop --}}
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="control-label col-md-4">Afsluiter:</label>

                                    <div class="col-md-8">
                                        <select name="afsluiter_id" class="form-control">
                                            <option value="">-- Geen persoon geselecteerd --</option>

                                            @foreach ($persons as $person1) {{-- Loop through thez persons --}} 
                                                <option value="{{ $person1->id }}">{{ $person1->name }}</option>
                                            @endforeach {{-- End loop --}}
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="control-label col-md-4">Kapoenen lokaal:</label>

                                    <div class="col-md-8">
                                        <select name="kapoenen_lokaal" class="form-control">
                                            <option value="N" @if ($lease->kapoenen_lokaal === 'N') selected @endif>Niet nodig tijdens verhuring</option>
                                            <option value="Y" @if ($lease->kapoenen_lokaal === 'Y') selected @endif>Zit bij in de verhuring</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="control-label col-md-4">Welpen lokaal:</label>

                                    <div class="col-md-8">
                                        <select name="welpen_lokaal" class="form-control">
                                            <option value="N" @if ($lease->welpen_lokaal === 'N') selected @endif>Niet nodig tijdens verhuring</option>
                                            <option value="Y" @if ($lease->welpen_lokaal === 'Y') selected @endif>Zit bij in de verhuring</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="control-label col-md-4">Jong-givers lokaal:</label>

                                    <div class="col-md-8">
                                        <select name="jongGivers_lokaal" class="form-control">
                                            <option value="N" @if ($lease->jongGivers_lokaal === 'N') selected @endif>Niet nodig tijdens verhuring</option>
                                            <option value="Y" @if ($lease->jongGivers_lokaal === 'Y') selected @endif>Zit bij in de verhuring</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="control-label col-md-4">Givers Lokaal:</label>

                                    <div class="col-md-8">
                                        <select name="givers_lokaal" class="form-control">
                                            <option value="N" @if ($lease->givers_lokaal === 'N') selected @endif>Niet nodig tijdens verhuring</option>
                                            <option value="Y" @if ($lease->givers_lokaal === 'Y') selected @endif>Zit bij in de verhuring</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label name="jins_lokaal" class="control-label col-md-4">Jins lokaal:</label>

                                    <div class="col-md-8">
                                        <select name="jins_lokaal" class="form-control">
                                            <option value="N" @if ($lease->jins_lokaal === 'N') selected @endif>Niet nodig tijdens verhuriong</option>
                                            <option value="Y" @if ($lease->jins_lokaal === 'Y') selected @endif>Zit bij de verhuring</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="control-label col-md-4">Grote zaal:</label>

                                    <div class="col-md-8">
                                        <select name="grote_zaal" class="form-control">
                                            <option value="N">Niet nodig tijdens de verhuring</option>
                                            <option value="Y">Zit bij de verhuring</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="control-label col-md-4">Toiletten: <small>(kl. bouw)</small></label>

                                    <div class="col-md-8">
                                        <select name="toiletten" class="form-control">
                                            <option value="N">Niet nodig tijdens de verhuring</option>
                                            <option value="Y">Zit bij de verhuring</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend></legend> {{-- Empty legend is set for the breakline in the view. --}}

                                <div class="col-md-6 form-group">
                                    <div class="col-md-offset-4 col-md-8">
                                        <button type="submit" class="btn btn-flat btn-sm btn-success">
                                            <span class="fa fa-check" aria-hidden="true"></span> Verhuring aanpassen
                                        </button>

                                        <button type="reset" class="btn btn-flat btn-sm btn-danger">
                                            <span class="fa fa-undo" aria-hidden="true"></span> Wijziging annuleren
                                        </button>
                                    </div>
                                </div>
                            </fieldset>

                        </form>
                    </div>
                </div>
            </div> {{-- END info tab --}}

            <div class="tab-pane" id="tab_2"> {{-- Start notitions tab --}}
                <div class="row">
                    <div class="col-md-8">
                        @if ($lease->notitions()->count() === 0) {{-- There are no notitions in the system. --}}
                            <div class="alert alert-info alert-important">
                                <strong><span class="fa phpdebugbar-fa-info-circle"></span> Info:</strong>
                                Er zijn geen notities omtrent deze verhuring.
                            </div>
                        @else {{-- There are notitions in the system. --}}
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Autheur:</th>
                                        <th>Notitie:</th>
                                        <th colspan="2">Aangemaakt op:</th> {{-- colspan="2" needed for the functions. --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lease->notitions as $note) {{-- Loop throught the notes. --}}
                                        <tr>
                                            <td><strong><code>#{!! $note->id !!}</code></strong></td>
                                            <td>{{ $note->author->name }}</td>
                                            <td>{{ $note->text }}</td>
                                            <td>{{ $note->created_at }}</td>

                                            <td> {{-- Options --}}
                                                @if (auth()->user()->id === $note->author_id || auth()->user()->hasRole('Admin'))
                                                    {{-- Check the permission before a user can delete the note --}}

                                                    <a href="{{ route('lease.notitie.delete', ['notitionId' => $note->id, 'leaseId' => $lease->id]) }}" class="label label-danger">
                                                        <span class="fa fa-trash" aria-hidden="true"></span> Verwijder
                                                    </a>
                                                @endif
                                            </td> {{-- END options --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                        <hr> {{-- Breakline for the form. --}}

                        <form action="{{ route('lease.notitie.add') }}" method="post" class="form-horizontal">
                            {{ csrf_field() }}
                            <input type="hidden" name="lease_id" value="{{ $lease->id }}">

                            <div class="form-group">
                                <div class="col-md-12">
                                    <textarea name="text" rows="5" class="form-control" placeholder="Uw notitie omtrent deze verhuur"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-sm btn-flat btn-success">
                                        <span class="fa fa-check" aria-hidden="true"></span> Opslaan
                                    </button>

                                    <button type="reset" class="btn btn-sm btn-flat btn-danger">
                                        <span class="fa fa-undo" aria-hidden="true"></span> Reset
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> {{-- END notitions tab --}}
        </div>
        <!-- /.tab-content -->
    </div>
@endsection
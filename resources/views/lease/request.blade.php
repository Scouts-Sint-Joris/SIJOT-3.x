@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <img class="img-rounded img-front" src="{{ asset('img/front.jpg') }}">
            </div>
        </div>

        <div class="row row-padding-top">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12"> {{-- Page header --}}
                                <div style="margin-top: -20px;" class="page-header">
                                    <h2 style="margin-bottom: -5px;">Verhuur aanvraag</h2>
                                </div>
                            </div> {{-- /Page header --}}

                            <div class="col-md-9"> {{-- Content --}}
                                <p>
                                    Heb je intresse in onze lokalen als kampplaats, weekend, of bijeenkomst?
                                    Dan kun je hier een verhuring aanvragen. <br>

                                    <span class="text-danger">
                                        Maar let wel op het laatste weekend van een maand verhuren wij niet,
                                        doorheen het werkingsjaar. (September - Juni)
                                    </span>
                                </p>

                                <form method="POST" action="{{ route('lease.store') }}" class="form-lease-request form-horizontal">
                                    {{ csrf_field() }} {{-- CSRF TOKEN --}}
                                    <input type="hidden" name="status_id" value="1"> {{-- Indicates lease status --}}

                                    <div class="form-group {{ $errors->has('start_datum') ? 'has-error' : '' }}">
                                        <label class="control-label col-sm-2">
                                            Start datum: <span class="text-danger">*</span>
                                        </label>

                                        <div class="col-sm-5">
                                            <input type="date" class="form-control" name="start_datum" placeholder="Start datum verhuring">

                                            @if ($errors->has('start_datum'))
                                                <span class="help-block"><strong>{{ $errors->first('start_datum') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('eind_datum') ? 'has-error' : '' }}">
                                        <label class="control-label col-sm-2">
                                            Eind datum: <span class="text-danger">*</span>
                                        </label>

                                        <div class="col-md-5">
                                            <input type="date" class="form-control" name="eind_datum" placeholder="Eind datum verhuring">

                                            @if ($errors->has('eind_datum'))
                                                <span class="help-block"><strong>{{ $errors->first('eind_datum') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('groeps_naam') ? 'has-error' : '' }}">
                                        <label class="control-label col-sm-2">
                                            Groep: <span class="text-danger">*</span>
                                        </label>

                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="groeps_naam" placeholder="Groep">

                                            @if ($errors->has('groeps_naam'))
                                                <span class="help-block"><strong>{{ $errors->first('groeps_naam') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('contact_email') ? 'has-error' : '' }}">
                                        <label class="control-label col-sm-2">
                                            E-mail: <span class="text-danger">*</span>
                                        </label>

                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="contact_email" placeholder="E-mail adres v/d contactpersoon">

                                            @if ($errors->has('contact_email'))
                                                <span class="help-block"><strong>{{ $errors->first('contact_email') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-2">
                                            GSM-nummer: {{-- <span class="text-danger">*</span> --}}
                                        </label>

                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="tel_nummer" placeholder="GSM-nummer v/d contact persoon">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                    <span class="col-md-5 col-md-offset-2">
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <span class="fa fa-btn fa-check" aria-hidden="true"></span> Aanvragen
                                        </button>

                                        <button type="reset" class="btn btn-sm btn-danger">
                                            <span class="fa fa-btn fa-close" aria-hidden="true"></span> Reset
                                        </button>
                                    </span>
                                    </div>
                                </form>
                            </div>  {{-- /Content --}}

                            <div class="col-md-3"> {{-- Sidebar --}}
                                @include('lease.includes.sidebar')
                            </div> {{-- /Sidebar --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('layouts.modules.footer')
@endsection
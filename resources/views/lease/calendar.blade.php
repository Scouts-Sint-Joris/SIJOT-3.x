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
                            <div class="col-sm-12">
                                <div style="margin-top: -20px;" class="page-header">
                                    <h2 style="margin-bottom: -5px;">Verhuur kalender:</h2>
                                </div>
                            </div>

                            <div class="col-md-9">
                                <p>
                                    Hier vind u wanner onze lokalen al reeds verhuurd zijn.
                                    Vind u hier de datum niet dat u onze lokalen wilt huren leg dan snel je datum vast.
                                    Dat doe je door dit <a href="{{ route('lease.request') }}">formulier</a> in te vullen.
                                </p>

                                @if ((int) count($leases) > 0)
                                    <table class="table-condensed table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="col-md-3 text-center">Start datum:</th>
                                                <th class="col-md-2"></th> {{-- empty cell needed because the prefix word. --}}
                                                <th class="col-md-3 text-center">Eind datum:</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($leases as $lease)
                                                <tr>
                                                    <td class="col-md-3 text-center">{{ $lease->start_datum->format('d/m/Y') }}</td>
                                                    <td class="col-md-2 text-center">tot</td>
                                                    <td class="col-md-3 text-center">{{ $lease->eind_datum->format('d/m/Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    {{ $leases->render() }} {{-- Pagination --}}
                                @else
                                    <div class="alert alert-info" role="alert">
                                        <strong><span class="fa fa-info-circle" aria-hidden="true"></span> Info:</strong>
                                        Er zijn geen bevestigde verhuringen momenteel.
                                    </div>
                                @endif
                            </div>

                            <div class="col-sm-3">
                                @include('lease.includes.sidebar')
                            </div>
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

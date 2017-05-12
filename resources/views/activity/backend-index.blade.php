@extends('layouts.backend')

@section('title')
    <h1> Activiteiten <small>beheers paneel</small></h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('backend') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Activiteiten</li>
    </ol>
@endsection

@section('content')
    <div class="box"> {{-- Default box --}}
        <div class="box-header with-border">
            <h3 class="box-title">Activiteiten</h3>

            <div class="pull-right">
                <a class="label label-danger" href="#" data-toggle="modal" data-target="#create-activity">Activiteit toevoegen</a>
            </div>
        </div>

        <div class="box-body">
            @if ((int) count($activities) === 0)
                <div class="alert alert-info alert-important" role="alert">
                    <strong>
                        <span class="fa fa-info-circle" aria-hidden="true"></span> Info:
                    </strong>

                    Er zijn geen Activiteiten gevonden in het systeem.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Groep:</th>
                                <th>Status:</th>
                                <th>Datum:</th>
                                <th>Titel:</th>
                                <th colspan="2">Toegevoegd op:</th> {{-- Colspanneeded for the functions --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activity)
                                <tr>
                                    <td><strong>#{{ $activity->id }}</strong></td>
                                    <td>{{ $activity->group->title }}</td>
                                    <td>
                                        @if ((int) $activity->status === 0)
                                            <span class="label label-warning">Klad versie</span>
                                        @elseif ((int) $activity->status === 1)
                                            <span class="label label-success">Gepubliceerd</span>
                                        @endif
                                    </td>
                                    <td>{{ $activity->activiteit_datum->format('d-m-Y') }} van {{ $activity->start_hour->format('H:i') }}u tot {{ $activity->end_hour->format('H:i') }}u</td>
                                    <td>{{ $activity->title }}</td>
                                    <td>{{ $activity->created_at->format('d-m-y H:i:s') }}</td>

                                    <td class="pull-right"> {{-- Functions --}}
                                        @if ((int) $activity->status === 0)
                                            <a href="{{ route('activity.status', ['status' => 1, 'id' => $activity->id]) }}" class="label label-warning">Zet naar klad</a>
                                        @elseif ((int) $activity->status === 1)
                                            <a href="{{ route('activity.status', ['status' => 0, 'id' => $activity->id]) }}" class="label label-warning">Zet naar klad</a>
                                        @endif

                                        <a href="" class="label label-info">Bekijk</a>
                                        <a href="#" onclick="update('{{ route('activity.json', $activity) }}', '#update')" class="label label-warning">Aanpassen</a>
                                        <a href="{{ route('activity.delete', $activity) }}" class="label label-danger">Verwijder</a>
                                    </td> {{-- /Functions --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div> {{-- /.box-body --}}
    </div> {{-- /.box --}}

    {{-- Modal includes --}}
        @include('activity.backend-create')
        @include('activity.backend-update')
    {{-- /Modal includes --}}
@endsection

@section('extra-js')
    <script src="{{ asset('js/datepicker.js') }}"></script>
    <script src="{{ asset('js/activities.js') }}"></script>
@endsection
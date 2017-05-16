@extends('layouts.backend')

@section('title')
    <h1> Evenementen <small>beheers paneel</small></h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('backend') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Evenementen</li>
    </ol>
@endsection

@section('content')
    <div class="box"> {{-- Default box --}}
        <div class="box-header with-border">
            <h3 class="box-title">Evenementen</h3>

            <div class="pull-right">
                <a class="label label-danger" href="#" data-toggle="modal" data-target="#create-event">Evenement toevoegen</a>
            </div>
        </div>

        <div class="box-body">
            @if ((int) count($events) === 0)
                <div class="alert alert-info alert-important">
                    <strong><span class="fa fa-info-circle" aria-hidden="true"></span> Info:</strong>
                    Er zijn nog geen evenementen aangemaakt.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Aangemaakt door:</th>
                                <th>Status:</th>
                                <th>Titel:</th>
                                <th>Start datum:</th>
                                <th colspan="2">Eind datum:</th> {{-- colspan="2" needed for the functions. --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <td><strong>#{{ $event->id }}</strong></td>
                                    <td>{{ $event->author->name }}</td>

                                    <td> {{-- Status indication --}}
                                        @if ((int) $event->status === 0)
                                            <span class="label label-warning">Klad versie</span>
                                        @elseif ((int) $event->status === 1)
                                            <span class="label label-success">Gepubliceerd</span>
                                        @endif
                                    </td> {{-- /Status indication --}}

                                    <td>{{ $event->title }}</td>
                                    <td>{{ $event->start_date->format('d-m-Y') }} om {{ $event->start_hour->format('H:i') }}</td>
                                    <td>{{ $event->end_date->format('d-m-y') }} om {{ $event->end_hour->format('H:i') }}</td>

                                    <td class="pull-right"> {{-- Options --}}
                                        @if ((int) $event->status === 0) {{-- The event has the status 'klad' --}}
                                            <a href="{{ route('events.status', ['status' => 1, 'id' => $event->id]) }}" class="label label-success">Publiceer</a>
                                        @elseif ((int) $event->status === 1) {{-- The event has the status 'Publish' --}}
                                            <a href="{{ route('events.status', ['status' => 0, 'id' => $event->id]) }}" class="label label-warning">Zet naar klad</a>
                                        @endif

                                        <a href="{{ route('events.show', $event) }}" class="label label-info">Bekijk</a>
                                        <a href="" class="label label-primary">Aanpassen</a>
                                        <a href="{{ route('events.delete', $event) }}" class="label label-danger">Verwijder</a>
                                    </td> {{-- /Options --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div> {{-- /.box-body --}}
    </div> {{-- /.box --}}

    {{-- Modal includes --}}
        @include('events.create')
    {{-- /Modal includes --}}
@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
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
                                    <h2 style="margin-bottom: -5px;">{{ $event->title }}</h2>
                                </div>
                            </div> {{-- /Page header --}}
                        </div>

                        <div class="row">
                            <div class="col-md-9"> {{-- Content --}}

                            </div> {{-- Content --}}

                            <div class="col-md-3"> {{-- Sidebar --}}
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        Start: <span class="pull-right">{{ $event->start_date->format('d-m-Y') }} om {{ $event->start_hour->format('H:i') }}u</span>
                                    </li>

                                    <li class="list-group-item">
                                        Eind: <span class="pull-right">{{ $event->end_date->format('d-m-Y') }} om {{ $event->end_hour->format('H:i') }}u</span>
                                    </li>
                                </ul>

                                <div class="list-group">
                                    @if (auth()->check())
                                        <a href="" class="list-group-item list-group-item-warning">
                                            <i class="fa fa-btn fa-pencil" aria-hidden="true"></i> Wijzig
                                        </a>
                                        <a href="" class="list-group-item list-group-item-danger">
                                            <i class="fa fa-btn fa-close" aria-hidden="true"></i> Verwijder
                                        </a>
                                    @else
                                        <a href="mailto:" class="list-group-item">
                                            <i class="fa fa-btn fa-envelope" aria-hidden="true"></i> Ik heb een vraag.
                                        </a>
                                    @endif
                                </div>
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
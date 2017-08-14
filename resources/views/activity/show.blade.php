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
                                        <h2 style="margin-bottom: -5px;">
                                            {{ $activity->title }}
                                            <small class="pull-right">
                                                {{ $activity->activiteit_datum->format('d-m-Y') }} - {{ $activity->start_hour->format('H:i')  }} tot {{ $activity->end_hour->format('H:i') }}
                                            </small>
                                        </h2>
                                    </div>
                                </div> {{-- /Page header --}}

                                <div class="col-md-9"> {{-- Content --}}
                                    {!! Markdown::convertToHtml($activity->description) !!}
                                </div>  {{-- /Content --}}

                                <div class="col-md-3"> {{-- Sidebar --}}
                                    <div class="list-group">
                                        @if (auth()->check())
                                            <a href="" class="list-group-item list-group-item-warning"><span class="fa fa-pencil" aria-hidden="true"></span> Wijzig</a>
                                            <a href="" class="list-group-item list-group-item-danger"><span class="fa fa-close" aria-hidden="true"></span> Verwijder</a>
                                        @else
                                            <a href="mailto:" class="list-group-item"><span class="fa fa-btn fa-envelope" aria-hidden="true"></span> Ik heb nog vragen.</a>
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
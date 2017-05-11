@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <img class="img-rounded img-front" src="{{ asset('img/front.jpg') }}">
        </div>
    </div>

    <div class="row row-padding-top">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-9"> {{-- Content --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-header" style="margin-top: -20px;">
                                    <h2 style="margin-bottom: -5px;">Nieuws</h2>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                @if ((int) count($news) === 0)
                                    <div class="alert alert-info" role="alert">
                                        Er zijn momenteel geen nieuws berichten.
                                    </div>
                                @else
                                @endif
                            </div>
                        </div>
                    </div> {{-- content --}}
                    <div class="col-md-3"> {{-- Sidebar --}}
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Evenementen:
                            </div>

                            @if ((int) count($events) === 0)
                                <div class="panel-body">
                                    <small>(Er zijn geen evenementen).</small>
                                </div>
                            @else
                            @endif
                        </div>
                    </div> {{-- Sidebar --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include('layouts.modules.footer')
@endsection

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

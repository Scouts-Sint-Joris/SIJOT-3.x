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
                                    <h2 style="margin-bottom: -5px;">{{ $group->title }} <small>{{ $group->sub_title }}</small></h2>
                                </div>
                            </div>

                            <div class="col-md-9"> {{-- Content --}}
                                {!! Markdown::convertToHtml($group->description) !!}
                            </div> {{-- /Content --}}

                            <div class="col-sm-3">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Activiteiten:
                                        <a href="{{ route('activity.feed', $group->id) }}" target="_blank" style="color: orange; float: right; padding-top: 5px;" class="fa fa-rss" aria-hidden="true"></a>
                                    </div>

                                    @if ((int) count($activities) > 0) {{-- There are activities in the database.  --}}
                                    @else {{-- No activities found. --}}
                                    <div class="panel-body">
                                        <small><i>(Geen activiteiten voor deze groep.)</i></small>
                                    </div>
                                    @endif
                                </div>
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
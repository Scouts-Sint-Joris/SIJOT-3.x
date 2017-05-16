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
                                    @foreach($news as $article)
                                        <div style="margin-left: -15px;" class="col-sm-12">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h4><strong><a href="{{ route('news.show', $article) }}">{{ $article->title }}</a></strong></h4>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <a href="{{ route('news.show', $article) }}" class="thumbnail">
                                                        <img src="http://placehold.it/260x180" alt="{{ $article->title }}">
                                                    </a>
                                                </div>

                                                <div class="col-md-9">
                                                    <p> {{ $article->message }} </p>
                                                    <p><a class="btn btn-sm btn-info" href="{{ route('news.show', $article) }}">Lees meer...</a></p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12" style="margin-top: -20px;">
                                                    <p></p>

                                                    <p>
                                                        <i class="fa fa-user" aria-hidden="true"></i> Autheur: <a href="#">{{ $article->author->name }}</a>
                                                        | <i class="fa fa-calendar" aria-hidden="true"></i> {{ $article->created_at }}
                                                        | <i class="fa fa-tags" aria-hidden="true"></i> Tags:

                                                        @if ((int) count($article->categories) > 0)
                                                            @foreach($article->categories as $category)
                                                                <a href="#"><span class="label label-info">{{ $category->category }}</span></a>
                                                            @endforeach
                                                        @else
                                                            <span class="label label-primary">Geen</span>
                                                        @endif

                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
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
                                <div class="panel-body">
                                    <ul style="margin-bottom: -5px; margin-top: -5px;" class="list-unstyled">
                                        @foreach ($events as $event)
                                            <li> - <a href="{{ route('events.show', $event) }}">{{ ucfirst($event->title) }}</a> </li>
                                        @endforeach
                                    </ul>
                                </div>
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

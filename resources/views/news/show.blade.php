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
                            <div class="col-sm-12">
                                <div style="margin-top: -20px;" class="page-header">
                                    <h2 style="margin-bottom: -5px;">{{ $news->title }}</h2>
                                </div>
                            </div>

                            <div class="col-md-9"> {{-- Content --}}
                                {!! Markdown::convertToHtml($news->message) !!}
                            </div> {{-- /Content --}}

                            <div class="col-sm-3">
                                <div class="well well-sm">
                                    <form method="POST" action="">
                                        {{-- CSRF --}}
                                        {{ csrf_field() }}


                                        <div class="input-group">
                                            <input type="text" name="term" class="form-control" placeholder="Zoek bericht">

                                            <span class="input-group-btn">
	                    		                <button class="btn btn-success" type="button">
	                    			                <i class="fa fa-search" aria-hidden="true"></i>
	                     		                </button>
	                    	                </span>
                                        </div>
                                    </form>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">Categorieen:</div>

                                    @if ((int) count($categories) > 0)
                                    @else
                                        <div class="panel-body">
                                            <small><i>(Er zijn geen categorieen).</i></small>
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
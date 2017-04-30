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
                                    <h2 style="margin-bottom: -5px;">Takken</h2>
                                </div>
                            </div> {{-- /Page header --}}

                            <div class="col-md-9"> {{-- Content --}}
                                <div class="well well-sm color-kapoenen">
                                    <div class="media">
                                        <a class="pull-left" href="">
                                            <img class="img-tak color-white img-responsive img-rounded media-object" src="{{ asset('img/kapoenen.svg') }}" alt="{{ $title->sub_title }}">
                                        </a>
                                        <div class="media-body color-white">
                                            <h4 class="font-title media-heading"> {{ $kapoenen->title }} <small> {{ $kapoenen->sub_title }} </small></h4>

                                            <!-- Description -->
                                            Het leven van een kapoen (6-8jaar) is er één vol spel, fantasie,
                                            creativiteit en expressie. Spelenderwijs en ongedwongen ontdekken
                                            we samen met hen de wereld.
                                            De leiding gaat hierbij uit van de kapoen zelf, van het wat hen boeit en…
                                        </div>
                                    </div>
                                </div>

                                <div class="well well-sm color-welpen">
                                    <div class="media">
                                        <a class="pull-left" href="">
                                            <img class="img-tak color-white img-responsive img-rounded media-object" src="{{ asset('img/welpen.svg') }}" alt="{{ $welpen->title }}">
                                        </a>
                                        <div class="media-body color-white">
                                            <h4 class="font-title media-heading"> {{ $welpen->title }} <small> {{ $welpen->sub_title }} </small></h4>

                                            <!-- Description -->
                                            Het leven van een kapoen (6-8jaar) is er één vol spel, fantasie,
                                            creativiteit en expressie. Spelenderwijs en ongedwongen ontdekken
                                            we samen met hen de wereld.
                                            De leiding gaat hierbij uit van de kapoen zelf, van het wat hen boeit en…
                                        </div>
                                    </div>
                                </div>

                                <div class="well well-sm color-jonggivers">
                                    <div class="media">
                                        <a class="pull-left" href="">
                                            <img class="img-tak color-white img-responsive img-rounded media-object" src="{{ asset('img/jonggivers.svg') }}" alt="{{ $jongGivers->title }}">
                                        </a>
                                        <div class="media-body color-white">
                                            <h4 class="font-title media-heading"> {{ $jongGivers->title }} <small> {{ $jongGivers->sub_title }} </small></h4>

                                            <!-- Description -->
                                            Het leven van een kapoen (6-8jaar) is er één vol spel, fantasie,
                                            creativiteit en expressie. Spelenderwijs en ongedwongen ontdekken
                                            we samen met hen de wereld.
                                            De leiding gaat hierbij uit van de kapoen zelf, van het wat hen boeit en…
                                        </div>
                                    </div>
                                </div>

                                <div class="well well-sm color-givers">
                                    <div class="media">
                                        <a class="pull-left" href="">
                                            <img class="img-tak color-white img-responsive img-rounded media-object" src="{{ asset('img/givers.svg') }}" alt="{{ $jongGivers->title }}">
                                        </a>
                                        <div class="media-body color-white">
                                            <h4 class="font-title media-heading"> {{ $givers->title }} <small> {{$givers->sub_title}} </small></h4>

                                            <!-- Description -->
                                            Het leven van een kapoen (6-8jaar) is er één vol spel, fantasie,
                                            creativiteit en expressie. Spelenderwijs en ongedwongen ontdekken
                                            we samen met hen de wereld.
                                            De leiding gaat hierbij uit van de kapoen zelf, van het wat hen boeit en…
                                        </div>
                                    </div>
                                </div>

                                <div class="well well-sm color-jins">
                                    <div class="media">
                                        <a class="pull-left" href="">
                                            <img class="img-tak color-white img-responsive img-rounded media-object" src="{{ asset('img/jins.svg') }}" alt="{{ $jins->title }}">
                                        </a>
                                        <div class="media-body color-white">
                                            <h4 class="font-title media-heading"> {{ $jins->title }} <small> {{ $jins->sub_title }} </small></h4>

                                            <!-- Description -->
                                            Het leven van een kapoen (6-8jaar) is er één vol spel, fantasie,
                                            creativiteit en expressie. Spelenderwijs en ongedwongen ontdekken
                                            we samen met hen de wereld.
                                            De leiding gaat hierbij uit van de kapoen zelf, van het wat hen boeit en…
                                        </div>
                                    </div>
                                </div>

                                <div class="well well-sm color-leiding">
                                    <div class="media">
                                        <a class="pull-left" href="">
                                            <img class="img-tak color-white img-responsive img-rounded media-object" src="{{ asset('img/leiding.svg') }}" alt="{{ $leiding->title }}">
                                        </a>
                                        <div class="media-body color-white">
                                            <h4 class="font-title media-heading"> {{ $leiding->title }} <small> van 6 tot 8 jaar </small></h4>

                                            <!-- Description -->
                                            Het leven van een kapoen (6-8jaar) is er één vol spel, fantasie,
                                            creativiteit en expressie. Spelenderwijs en ongedwongen ontdekken
                                            we samen met hen de wereld.
                                            De leiding gaat hierbij uit van de kapoen zelf, van het wat hen boeit en…
                                        </div>
                                    </div>
                                </div>
                            </div>  {{-- /Content --}}

                            <div class="col-md-3"> {{-- Sidebar --}}
                                @include('groups.includes.sidebar')
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
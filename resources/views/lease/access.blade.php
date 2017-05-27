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
                        <div class="row">
                            <div class="col-md-12"> {{-- Page-header --}}
                                <div style="margin-top: -20px;" class="page-header">
                                    <h2 style="margin-bottom: -5px;">Verhuur bereikbaarheid</h2>
                                </div>
                            </div>

                            <div class="col-md-9"> {{-- Content --}}
                                <h4>Eigen vervoer:</h4>

                                <p>
                                    U kunt de trein of bus naar turnhout nemen. En vervolgens kunt met de bus verder naar de scoutsdomeinen. (Sint-Jorislaan 11).
                                    De bus die u kunt nemen heeft de nr 2. vervolgens stapt u af aan in de rozenlaan. En vanaf daar is het nog slechts 500 meter wandelen.
                                </p>

                                <h4>Openbaar vervoer:</h4>

                                    <p>
                                        - Neem de E34 afslag 24 Turnhout-centrum. <br>
                                        - Neem vervolgens de N19 richting Steenweg op Zevendonk. <br>
                                        - Sla vervolgens de Everdrongenlaan in. <br>
                                        - Vervolgens slaagt u in Rozenlaan. <br>
                                        - Sla vervolgens de Sint-Jorislaan in <br>
                                    </p>
                                </div> {{-- /Content --}}

                                <div class="col-md-3"> {{-- Sidebar --}}
                                    @include('lease.includes.sidebar')
                                </div> {{-- /Sidebar --}}
                            </div> {{-- /Page header --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('footer')
    @include('layouts.modules.footer')
@endsection
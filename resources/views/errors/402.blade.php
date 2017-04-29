@extends('layouts.error')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <h1><i class="fa fa-ban red"></i> U hebt geen toegang.</h1>
            <p class="lead">Sorry! U hebt geen toegang tot de beheers systemen van deze website.</p>
            <p><a onclick=javascript:checkSite(); class="btn btn-default btn-lg green">Ga terug</a>
                <script type="text/javascript">
                    function checkSite(){
                        var currentSite = window.location.hostname;
                        window.location = "http://" + currentSite;
                    }
                </script>
            </p>
        </div>
    </div>
    <div class="container">
        <div class="body-content">
            <div class="row">
                <div class="col-md-6">
                    <h2>Wat is er gebeurd?</h2>
                    <p class="lead">
                        U bent van de toegang ontzegd wegens, {{ auth()->user()->bans()->first()->comment }}
                    </p>
                </div>

                <div class="col-md-6">
                    <h2>Wat kan ik doen?</h2>
                    <p>
                        Als u denkt dat dit een misverstand of fout is dan kunt u contact opnemen met de media verantwoordelijke,
                        van Scouts En Gidsen Sint-Joris, Turnhout
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.error')

@section('content')
    <div class="container">
        <!-- Jumbotron -->
        <div class="jumbotron">
            <h1><i class="fa fa-frown-o red"></i> 404 - Pagina niet gevonden</h1>
            <p class="lead">Wij konden de pagina die u zocht niet vinden op <em><span id="display-domain"></span></em>.</p>
            <p><a onclick=javascript:checkSite(); class="btn btn-default btn-lg"><span class="green"><span class="fa fa-undo"></span> Ga terug</span></a>
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
                    <h2>Wat gebeurd er?</h2>
                    <p class="lead">Een 404 fout status geeft aan dat de pagina of bestand niet gevonden word op de server.</p>
                </div>
                <div class="col-md-6">
                    <h2>Wat kan ik doen?</h2>
                    <p class="lead">Als u een bezoeker bent</p>
                    <p>
                        Gebruik de ga terug knop in de browser en kijk na of u op de juiste pagina bent.
                        Als u dringend assistentie nodig hebt kun u ons <a href="mailto:topairy@gmail.com">mailen.</a>
                    </p>
                    <p class="lead">Als u de eigenaar bent</p>
                    <p>Kijk de url, logs na. Zodat u zeker bent dat u op de juiste plaats bent.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
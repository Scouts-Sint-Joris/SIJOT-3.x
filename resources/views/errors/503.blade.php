<!DOCTYPE html>
<html lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="In onderhoud">

        <title>In onderhoud.</title>

        <link rel="stylesheet" href="{{ asset('css/errors.css') }}">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

        <script type="text/javascript">
            function loadDomain() {
                var display = document.getElementById("display-domain");
                display.innerHTML = document.domain;
            }
        </script>
    </head>
    <body onload="javascript:loadDomain()">
        <div class="container">
            <!-- Jumbotron -->
            <div class="jumbotron">
                <h1><i class="fa fa-exclamation-triangle orange"></i> In onderhoud</h1>

                <p class="lead"><em>De website is momenteel in onderhoud. Wij zijn spoedig terug operatief.</p>
                <a href="javascript:document.location.reload(true);" class="btn btn-default btn-lg text-center"><span class="green">Probeer opnieuw.</span></a>
            </div>
        </div>
        <div class="container">
            <div class="body-content">
                <div class="row">
                    <div class="col-md-6">
                        <h2>Reden van het onderhoud.</h2>
                        <p class="lead">
                            {{ json_decode(file_get_contents(storage_path('framework/down')), true)['message'] }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h2>Wat kan ik doen?</h2>

                        <p class="lead">Als u een bezoeker bent.</p>
                        <p>U kunt gewoon wachten tot of het onderhoud is uitgevoerd. Indien je dringend hulp nodig hebt kunt u ons <a href="mailto:contact@st-joris-tunhout.be">mailen</a>.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>

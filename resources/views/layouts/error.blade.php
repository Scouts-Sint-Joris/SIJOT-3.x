<!DOCTYPE html>
<html lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Er is een fout opgetreden.">

        <title>Er is een fout opgetreden.</title>

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
        @yield('content')

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>
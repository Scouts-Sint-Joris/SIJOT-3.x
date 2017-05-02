<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <link href="https://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css" rel="stylesheet">

        <!-- Scripts -->
        <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};</script>
    </head>
    <body class="background">
        <div id="app">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="navbar-header">

                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <!-- Branding Image -->
                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'Sint-Joris') }}
                        </a>
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <span class="fa fa-leaf" aria-hidden="true"></span> Takken
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('groups.show', ['selector' => 'kapoenen']) }}">
                                            <span class="fa fa-btn fa-asterisk" aria-hidden="true"></span>De Kapoenen
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('groups.show', ['selector' => 'welpen']) }}">
                                            <span class="fa fa-btn fa-asterisk" aria-hidden="true"></span>De Welpen
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('groups.show', ['selector' => 'jongGivers']) }}">
                                            <span class="fa fa-btn fa-asterisk" aria-hidden="true"></span>De Jong-Givers
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('groups.show', ['selector' => 'givers']) }}">
                                            <span class="fa fa-btn fa-asterisk" aria-hidden="true"></span>De Givers
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('groups.show', ['selector' => 'jins']) }}">
                                            <span class="fa fa-btn fa-asterisk" aria-hidden="true"></span>De Jins
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('groups.show', ['selector' => 'leiding']) }}">
                                            <span class="fa fa-btn fa-asterisk" aria-hidden="true"></span>De Leiding
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li><a href="{{ route('lease')  }}"><span class="fa fa-home" aria-hidden="true"></span> Verhuur</a></li>
                            <li><a href="#"><span class="fa fa-picture-o" aria-hidden="true"></span> Foto's</a></li>
                            <li><a href="#"><span class="fa fa-info-circle" aria-hidden="true"></span> Info</a></li>
                            <li><a href="mailto:contact@st-joris-turnhout.be"><span class="fa fa-envelope" aria-hidden="true"></span> Contact</a></li>
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @if (Auth::guest())
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <span class="fa fa-sign-in" aria-hidden="true"></span> Inloggen
                                    </a>
                                    <ul id="login-dp" class="dropdown-menu">
                                        <li>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form class="form" role="form" method="post" action="{{ url('login') }}" accept-charset="UTF-8" id="login-nav">
                                                        {{ csrf_field() }} {{-- CSRF FIELD --}}

                                                        <div class="form-group">
                                                            <label class="sr-only" for="exampleInputEmail2">Email adres</label>
                                                            <input type="email" name="email" class="form-control" id="exampleInputEmail2" placeholder="Email adres" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="sr-only" for="exampleInputPassword2">Wachtwoord</label>
                                                            <input type="password" name="password" class="form-control" id="exampleInputPassword2" placeholder="Wachtwoord" required>
                                                            <div class="help-block text-right">
                                                                <a href="#" data-toggle="modal" data-target="#reset-pass">Wachtwoord vergeten?</a>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-primary btn-block">Inloggen</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        <span class="fa fa-user" aria-hidden="true"></span> {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ route('backend') }}"><span class="fa fa-arrow-right" aria-hidden="true"></span> Backend</a></li>
                                        <li><a href=""><span class="fa fa-cogs" aria-hidden="true"></span> Account configuratie</a><li>
                                        <li>
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <span class="fa fa-sign-out" aria-hidden="true"></span> Uitloggen
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>

            @yield('content')
        </div>

        @yield('footer')

        @if (Auth::guest())
            @include('layouts.modules.reset-password')
        @endif

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>

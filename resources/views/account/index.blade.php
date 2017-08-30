@extends('layouts.backend')

@section('title')
    <h1> Gebruikersprofiel <small> {{ $user->name }} </small> </h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('backend') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Account</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="#" class="list-group-item disabled"><strong>Menu:</strong></a>
                <a href="#settings" data-toggle="tab" class="list-group-item">Account informatie</a>
                <a href="#security" data-toggle="tab" class="list-group-item">Account veiligheid</a>

                @if ($user->hasRole('admin'))
                    <a href="#api" data-toggle="tab" class="list-group-item">API sleutels</a>
                @endif
            </div>
        </div>

        <div class="col-sm-9">
            <div class="tab-content">
                {{-- Includes --}}
                    @include('account.settings')
                    @include('account.security')

                    @if ($user->hasRole('admin')) {{-- If the user is an admin. Give him to possibility to make api keys. --}}
                        {{-- TODO: If the user is admin and the remove the role. They should also remove his api keys. --}}
                        @include('account.api')
                    @endif
                {{-- /Includes --}}
            </div>
        </div>
    </div>
@endsection
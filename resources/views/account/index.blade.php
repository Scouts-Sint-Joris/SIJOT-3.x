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
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{ asset('img/user.jpg') }}" alt="{{ auth()->user()->name }}">

                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Creatie:</b> <span class="pull-right">{{ $user->created_at }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Gewijzigd:</b> <span class="pull-right">{{ $user->updated_at }}</span>
                        </li>
                    </ul>

                    <a href="mailto:{{ $user->email }}" class="btn btn-primary btn-block"><b>Contact</b></a>
                </div>
            </div>
        </div>

        <div class="col-sm-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li><a href="#settings" data-toggle="tab">Account informatie</a></li>
                    <li><a href="#security" data-toggle="tab">Account veiligheid</a></li>
                    <li class="active"><a href="#notifications" data-toggle="tab">Notificaties</a></li>
                </ul>
                <div class="tab-content">
                    {{-- Includes --}}
                    @include('account.settings')
                    @include('account.security')
                    @include('account.notifications')
                    {{-- /Includes --}}
                </div>
            </div>
        </div>
    </div>
@endsection
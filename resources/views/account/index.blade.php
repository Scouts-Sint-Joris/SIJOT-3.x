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
                <a href="#settings" data-toggle="tab" class="list-group-item active">Account informatie</a></>
                <a href="#security" data-toggle="tab" class="list-group-item">Account veiligheid</a></li>
            </div>
        </div>

        <div class="col-sm-9">
            <div class="tab-content">
                {{-- Includes --}}
                    @include('account.settings')
                    @include('account.security')
                {{-- /Includes --}}
            </div>
        </div>
    </div>
@endsection
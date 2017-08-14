@extends('layouts.backend')

@section('title')
    <h1> Wijzig gebruikers toegangen. <small>(Access Control List)</small></h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('backend') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('users.index') }}">Gebruikers</a></li>
        <li class="active">Wijzig ACL</li>
    </ol>
@endsection

@section('content')
    <div class="box"> {{-- Default box --}}
        <div class="box-header with-border">
            <h3 class="box-title">Wijzig ACL: {{ $acl->name }}</h3>
        </div>
        <div class="box-body">
            <form action="" method="POST" class="form-horizontal">
                {{ csrf_field() }}

                <div class="form-group">
                    <label class="control-label col-md-1">Naam:</label>

                    <div class="col-md-3">
                        <input type="text" value="{{ $acl->name }}" class="form-control" disabled>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
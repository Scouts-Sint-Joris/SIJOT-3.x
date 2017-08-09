@extends('layouts.backend')

@section('title')
    <h1> Wijzig machtegingen {{ $user->name }}. <small>(Access Control List)</small></h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('backend') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('users.index') }}">Gebruikers</a></li>
        <li class="active">Wijzig {{ $user->name }}</li>
    </ol>
@endsection

@section('content')
    <div class="box"> {{-- Default box --}}
        <div class="box-header with-border">
            <h3 class="box-title">Wijzig ACL: {{ $user->name }}</h3>
        </div>
        <div class="box-body">
            <form action="" method="POST" class="form-horizontal">
                {{ csrf_field() }}

                <div class="form-group">
                    <label class="control-label col-md-1">Naam:</label>

                    <div class="col-md-3">
                        <input type="text" value="{{ $user->name }}" class="form-control" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-1">Email adres:</label>

                    <div class="col-md-3">
                        <input type="email" value="{{ $user->email }}" class="form-control" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-1">Gebr. groepen:</label>

                    <div class="col-md-3">
                        {!! Form::select('roles[]', $roles, $user->roles, ['class' => 'form-control', 'multiple']) !!}
                        <small class="help-block"> * Hou de CTRL toets ingedrukt om meerdere te selecteren. </small>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@extends('layouts.backend')

@section('title')
    <h1> Foto's <small>Beheerspaneel</small></h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('backend') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Foto's</li>
    </ol>
@endsection

@section('content')
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_1" data-toggle="tab">
                    <span class="fa fa-btn fa-list" aria-hidden="true"></span> Nieuwsberichten
                </a>
            </li>
            <li>
                <a href="#tab_3" data-toggle="tab">
                    <span class="fa fa-btn fa-list" aria-hidden="true"></span> Categorieen
                </a>
            </li>
        </ul>

        <div class="tab-content"> {{-- Tab content --}}
            <div class="tab-pane" id="tab_1">
            </div>

            <div class="tab-pane" id="tab_3">
            </div>
        </div>
@endsection
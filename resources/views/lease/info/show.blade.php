@extends('layouts.backend')

@section('title')
    <h1> Verhurings info <small>#{{ $lease->id }}: {{ $lease->groeps_naam }}</small></h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('backend') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('lease.backend') }}">Verhuur</a></li>
        <li class="active">#{{ $lease->id }}: {{ $lease->groeps_naam }}</li>
    </ol>
@endsection

@section('content')
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab"><span class="fa fa-info-circle" aria-hidden="true"></span> Info</a></li>
            <li><a href="#tab_2" data-toggle="tab"><span class="fa fa-file-text-o"></span> Notities</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
            </div>

            <div class="tab-pane" id="tab_1">
                @if ((int) count($lease->notitions()) === 0) {{-- There are no notitions in the system. --}}
                    <div class="alert alert-success alert-important">
                        <strong><span class="fa phpdebugbar-fa-info-circle"></span> Info:</strong>
                        Er zijn geen notities omtrent deze verhuring.
                    </div>
                @else {{-- There are notitions in the system. --}}
                @endif
            </div>
        </div>
        <!-- /.tab-content -->
    </div>
@endsection
@extends('layouts.backend')

@section('title')
    <h1> Groepen <small>beheers paneel</small></h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('backend') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Groepen</li>
    </ol>
@endsection

@section('content')
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            @foreach ($groups as $group)
                <li @if ($groups->first() == $group) class="active" @endif> {{-- If statements sets active class on the first element. --}}
                    <a href="#{{ $group->selector }}" data-toggle="tab"><span class="fa fa-leaf" aria-hidden="true"></span> {{ $group->title }}</a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach ($groups as $data)
                <div class="tab-pane @if ($groups->first() == $data) active @endif" id="{{ $data->selector }}">
                    <form action="" method="POST" class="form-horizontal">
                        {{ csrf_field() }} {{-- CSRF TOKEN --}}

                        <div class="form-group row">
                            <label class="control-label col-md-1">Titel: <span class="text-danger">*</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" value="{{ $data->title }}" name="title" placeholder="Titel">
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
        <!-- /.tab-content -->
    </div>
@endsection
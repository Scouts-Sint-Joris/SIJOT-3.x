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
                    <form action="{{ route('groups.update', ['id' => $data->id]) }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }} {{-- CSRF TOKEN --}}
                        <input type="hidden" name="title" value="{{ $data->title }}">

                        <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}"> {{-- Title form-group --}}
                            <label class="control-label col-md-1">Titel: <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" value="{{ $data->title }}" name="title" placeholder="Titel" disabled>

                                @if ($errors->has('title'))
                                    <span class="help-block"><strong>{{ $errors->first('title') }}</strong></span>
                                @endif
                            </div>
                        </div> {{-- /Title form-group --}}

                        <div class="form-group row {{ $errors->has('sub_title') ? 'has-error' : '' }}"> {{-- Sub title form-group --}}
                            <label class="control-label col-md-1">Sub titel: <span class="text-danger">*</span></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" value="{{ $data->sub_title }}" name="sub_title" placeholder="Sub titel">

                                @if ($errors->has('sub_title'))
                                    <span class="help-block"><strong>{{ $errors->first('sub_title') }}</strong></span>
                                @endif
                            </div>
                        </div> {{-- Sub title form-group --}}

                        <div class="form-group row {{ $errors->has('description') ? 'has-error' : '' }}"> {{-- Description form group --}}
                            <label class="control-label col-md-1">Beschrijving: <span class="text-danger">*</span></label>
                            <div class="col-sm-5">
                                <textarea rows="8" class="form-control" name="description" spellcheck="true">{{ $data->description }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
                                @else
                                    <span class="help-block"><i><small>(Dit veld ondersteund markdown).</small></i></span>
                                @endif
                            </div>
                        </div> {{-- /Description form-group --}}

                        <div class="form-group row"> {{-- Submit and reset button --}}
                            <div class="col-md-offset-1 col-md-5">
                                <button type="submit" class="btn btn-sm btn-success"><span class="fa fa-check" aria-hidden="true"></span> Aanpassen</button>
                                <button type="reset" class="btn btn-sm btn-danger"><span class="fa fa-close" aria-hidden="true"></span> Reset formulier</button>
                            </div>
                        </div> {{-- /Submit and reset button --}}
                    </form>
                </div>
            @endforeach
        </div> {{-- /.tab-content --}}
    </div>
@endsection
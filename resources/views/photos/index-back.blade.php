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
                    <span class="fa fa-btn fa-list" aria-hidden="true"></span> Foto albums
                </a>
            </li>
            <li>
                <a href="#tab_3" data-toggle="tab">
                    <span class="fa fa-btn fa-plus" aria-hidden="true"></span> Nieuw album
                </a>
            </li>
        </ul>

        <div class="tab-content"> {{-- Tab content --}}
            <div class="tab-pane active" id="tab_1"> {{-- Overview tab --}}
                @if (count($photos) == 0)
                    <div class="alert alert-info alert-important" role="alert">
                        <strong><span class="fa fa-info-circle" aria-hidden="true"></span> Info:</strong>
                        Er zijn geen verwijzingen naar foto albums geregistreerd in het systeem.
                    </div>
                @else
                    <table class="table table-condensed table-striped table-hover"> {{-- Overview table --}}
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Naam:</th>
                                <th>Versie:</th>
                                <th>Korte beschrijving:</th>
                                <th colspan="2">Toegevoegd op:</th> {{-- Colspan="2" nodig voor de opties. --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($photos as $photo)
                                <tr>
                                    <td><strong><code>#P{{ $photo->id }}</code></strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $photo->created_at }}</td>

                                    <td> {{-- Options --}}
                                        <a href="" class="label label-warning">Wijzig</a>
                                        <a href="" class="label label-danger">Verwijder</a>
                                    </td> {{-- END options --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table> {{-- /Overview table --}}
                @endif
            </div> {{-- END overview tab --}} 

            <div class="tab-pane" id="tab_3"> {{-- Create tab --}}
                <form class="form-horizontal" method="POST" action="{{ route('photos.store') }}" enctype="multipart/form-data">  {{-- Create form --}}
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label class="control-label col-md-1">
                            Naam: <span class="text-danger">*</span>
                        </label>                   

                        <div class="col-md-3">
                            <input class="form-control" placeholder="Naam foto album" name="title">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-1">
                            Groep: <span class="text-danger">*</span>
                        </label>

                        <div class="col-md-3">
                            <select name="group" class="form-control">
                                <option value="">-- Selecteer de groep --</option>

                                @foreach ($groups as $group) 
                                    <option value="{{ $group->id }}">{{ $group->title }}</option>
                                @endforeach
                            </select>
                        </div>                   
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-1">
                            Foto: <span class="text-danger">*</span>
                        </label>

                        <div class="col-md-3">
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-1">
                            Url: <span class="text-danger">*</span>
                        </label>

                        <div class="col-md-3">
                            <input type="text" class="form-control" name="url" placeholder="Link naar het album">
                            <small class="help-block">*Url naar het Facebook album.</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-1">
                            Beschrijving: <span class="text-danger">*</span>
                        </label>

                        <div class="col-md-3">
                            <textarea name="description" class="form-control" rows="5" placeholder="Beschrijving van het album. Hou deze zo kort mogelijk."></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-1 col-md-3">
                            <button type="submit" class="btn btn-flat btn-success btn-sm">
                                <span class="fa fa-check" aria-hidden="true"></span> Toevoegen
                            </button>

                            <button type="reset" class="btn btn-flat btn-danger btn-sm">
                                <span class="fa fa-undo" aria-hidden="true"></span> Reset
                            </button>
                        </div>                   
                    </div>
                </form> {{-- End create form. --}}
            </div> {{-- END create tab --}}
        </div>
@endsection
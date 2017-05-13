@extends('layouts.backend')

@section('title')
    <h1> Nieuwsberichten <small>Beheerspaneel</small></h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('backend') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Nieuwsberichten</li>
    </ol>
@endsection

@section('content')
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab"><span class="fa fa-btn fa-list" aria-hidden="true"></span> Nieuwsberichten</a></li>
            <li><a href="#tab_3" data-toggle="tab"><span class="fa fa-btn fa-list" aria-hidden="true"></span> Categorieen</a></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <span class="fa fa-btn fa-plus" aria-hidden="true"></span> Toevoegen <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li role="presentation"><a href="#tab_2" data-toggle="tab">Nieuwsbericht</a></li>
                    <li role="presentation"><a href="">Categorie</a></li>
                </ul>
            </li>
        </ul>

        <div class="tab-content"> {{-- Tab content --}}
            <div class="tab-pane active" id="tab_1"> {{-- News messages --}}
                @if ((int) count($news) > 0)
                    <div class="table-responsive">
                        <table class="table table-condensed table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Status:</th>
                                    <th>Auteur:</th>
                                    <th>Titel:</th>
                                    <th>Aangemaakt op:</th>
                                    <th colspan="2">Laatst aangepast:</th> {{-- Colspan="2" needed for the functions --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($news as $item)
                                    <tr>
                                        <td><strong>#{{ $item->id }}</strong></td>

                                        <td> {{-- Status --}}
                                            @if ((string) $item->publish === 'N')
                                                <span class="label label-warning">Klad versie</span>
                                            @elseif ((string) $item->publish === 'Y')
                                                <span class="label label-success">Gepubliceerd</span>
                                            @endif
                                        </td> {{-- /Status --}}
                                        <td>{{ $item->author->name }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>

                                        <td class="pull-right"> {{-- Options --}}
                                            @if ((string) $item->publish === 'N') {{-- Item is not published --}}
                                                <a href="{{ route('news.status', ['status' => 'Y', 'id' => $item->id]) }}" class="label label-success">Publiceer</a>
                                            @elseif((string) $item->publish === 'Y') {{-- Item is published --}}
                                                <a href="{{ route('news.status', ['status' => 'N', 'id' => $item->id]) }}" class="label label-warning">Zet naar klad</a>
                                            @endif

                                            <a href="" class="label label-info">Bekijk</a>
                                            <a href="" class="label label-default">Aanpassen</a>
                                            <a href="{{ route('news.delete', $item) }}" class="label label-danger">Verwijder</a>
                                        </td> {{-- /Options --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <strong><span class="fa fa-info-circle" aria-hidden="true"></span> Info:</strong>
                        Er zijn geen nieuws berichten in het systeem gevonden.
                    </div>
                @endif
            </div>{{-- /News messages --}}

            <div class="tab-pane" id="tab_2"> {{-- Add news message --}}
                <form class="form-horizontal" action="{{ route('news.store') }}" method="post">
                    {{ csrf_field() }} {{-- CSRF_TOKEN --}}
                    <input type="hidden" value="{{ auth()->user()->id }}" name="author_id">

                    <div class="row">
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label class="control-label col-md-1">Titel: <span class="text-danger">*</span></label>

                            <div class="col-md-3">
                                <input type="text" name="title" placeholder="Titel nieuwsbericht" class="form-control">

                                @if ($errors->has('title'))
                                    <span class="help-block">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-1">Status: <span class="text-danger">*</span></label>

                            <div class="col-md-3 {{ $errors->has('publish') ? 'has-error' : '' }}">
                                <select class="form-control" name="publish">
                                    <option value="">-- Selecteer de status --</option>
                                    <option value="Y">Publiceer</option>
                                    <option value="N">Klad versie</option>
                                </select>

                                @if ($errors->has('publish'))
                                    <span class="help-block">{{ $errors->first('publish') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('categories') ? ' has-error' : '' }}">
                            <label class="control-label col-md-1">Categorie: <span class="text-danger"></span></label>

                            <div class="col-md-3">
                                <select class="form-control" name="categories" multiple>
                                    <option value="" selected>-- Selecteer een optie --</option>

                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('categories'))
                                    <span class="help-block">{{ $errors->first('categories') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                            <label class="control-label col-md-1">Bericht: <span class="text-danger">*</span></label>

                            <div class="col-md-4">
                                <textarea name="message" rows="8" class="form-control" placeholder="Het nieuwsbericht"></textarea>

                                @if ($errors->has('message'))
                                    <span class="help-block">{{ $errors->first('message') }}</span>
                                @else
                                    <span class="help-block"><small><i>(Dit veld is markdown ondersteund.)</i></small></span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-1 col-md-4">
                                <button type="submit" class="btn btn-sm btn-success"><span class="fa fa-check" aria-hidden="true"></span> Aanmaken</button>
                                <button type="reset" class="btn btn-sm btn-danger"><span class="fa fa-undo" aria-hidden="true"></span> Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div> {{-- /Add news message --}}
        </div> {{-- /.tab-content --}}
    </div>
@endsection

@extends('layouts.backend')

@section('title')
    <h1> @lang('lease.page-backend-title-index')
        <small> @lang('lease.page-backend-sub-title-index') </small>
    </h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('backend') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">@lang('lease.page-backend-sub-title-index')</li>
    </ol>
@endsection

@section('content')
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab"><span class="fa fa-list" aria-hidden="true"></span> @lang('lease.title-box')</a></li>
            <li><a href="#tab_2" data-toggle="tab"><span class="fa fa-users" aria-hidden="true"></span> Verantwoordelijke</a></li>
            <li><a href="#tab_3" data-toggle="tab"><span class="fa fa-plus" aria-hidden="true"></span> Verantwoordelijke toevoegen</a></li>

            <li class="pull-right"><a href="#" data-toggle="modal" data-target="#create-lease"><span class="fa fa-plus" aria-hidden="true"></span> @lang('lease.btn-backend-add')</a></li>
            <li class="pull-right"><a href="{{ route('lease.export') }}"><span class="fa fa-file-text" aria-hidden="true"></span> @lang('lease.btn-backend-export')</a></li> 
        </ul>

        <div class="tab-content">
            <div class="tab-pane active fade in" id="tab_1"> {{-- Start verhuur overzicht pane --}}
                <table class="table table-condensed table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('lease.table-status')</th>
                                <th>@lang('lease.table-start-date')</th>
                                <th>@lang('lease.table-end-date')</th>
                                <th>@lang('lease.table-group')</th>
                                <th>@lang('lease.table-phone-number')</th>
                                <th colspan="2">@lang('lease.table-request-date')</th> {{-- Colspan 2 needed for the functions --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leases as $lease)
                                <tr>
                                    <td><code>#{!! $lease->id !!}</code></td>

                                    <td> {{-- Status indication --}}
                                        @if ((int) $lease->status_id === 1)
                                            <span class="label label-danger">@lang('lease.status-lease-new')</span>
                                        @elseif ((int) $lease->status_id  === 2)
                                            <span class="label label-warning">@lang('lease.status-lease-option')</span>
                                        @elseif ((int) $lease->status_id  === 3)
                                            <span class="label label-success">@lang('lease.status-lease-confirmed')</span>
                                        @endif
                                    </td> {{-- /Status indication --}}

                                    <td>{{ $lease->start_datum->format('d/m/Y') }}</td>
                                    <td>{{ $lease->eind_datum->format('d/m/Y') }}</td>
                                    <td><a href="mailto:{{ $lease->contact_email }}">{{ $lease->groeps_naam }}</a></td>
                                    <td>{{ $lease->tel_nummer }}</td>
                                    <td>{{ $lease->created_at->format('d/m/Y') }}</td>

                                    <td> {{-- Options --}}

                                        @if ((int) $lease->status_id === 1)
                                            <a href="{{ route('lease.status', ['status' => 'optie', 'id' => $lease->id]) }}" class="label label-warning">@lang('lease.status-lease-option')</a>
                                            <a href="{{ route('lease.status', ['status' => 'bevestigd', 'id' => $lease->id]) }}" class="label label-success">@lang('lease.status-lease-confirmed')</a>
                                        @elseif ((int) $lease->status_id === 2)
                                            <a href="{{ route('lease.status', ['status' => 'bevestigd', 'id' => $lease->id]) }}" class="label label-success">@lang('lease.status-lease-confirmed')</a>
                                        @elseif ((int) $lease->status_id === 3)
                                            <a href="{{ route('lease.status', ['status' => 'optie', 'id' => $lease->id]) }}" class="label label-warning">@lang('lease.status-lease-option')</a>
                                        @endif

                                        <a style="margin-left: 5px;" href="{{ route('lease.info.show', $lease) }}" class="label label-info">Gegevens</a>
                                        <a href="{{ route('lease.delete', ['id' => $lease->id]) }}" class="label label-danger">@lang('lease.btn-backend-delete')</a>
                                    </td> {{-- /Options --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $leases->render() }} {{-- Pagination --}}
            </div> {{-- End verhuring overzicht pane --}}

            <div class="tab-pane fade in" id="tab_2"> {{-- Start verantwoordelijke overzicht pane --}}

            </div> {{-- END verantwoordelijke overzicht panel --}}

            <div class="tab-pane fade in" id="tab_3"> {{-- Start verantwoordelijke toevoegen pane --}}
                <form action="" class="form-horizontal" method="POST">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label class="control-label col-md-1">Naam persoon: <span class="text-danger">*</span></label>

                        <div class="col-md-3">
                            <select name="person" class="form-control">
                                <option value="">-- Selecteer de persoon. --</option>

                                @foreach ($users as $user) {{-- Loop through the users. --}}
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach {{-- End users loop --}}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-1">Extra info:</label>

                        <div class="col-md-5">
                            <textarea name="info" placeholder="Extra informatie omtrent de verantwoordelijke." rows="5" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-1 col-md-11">
                            <button type="submit" class="btn btn-sm btn-flat btn-success">
                                <span class="fa fa-check" aria-hidden="true"></span> Opslaan
                            </button>

                            <button type="reset" class="btn btn-sm btn-flat btn-danger">
                                <span class="fa fa-undo" aria-hidden="true"></span> Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div> {{-- END verantwoordelijke toevoegen pane --}}
        </div>
        <!-- /.tab-content -->
    </div>

    {{-- Modal includes --}}
        @include('lease.backend-create')
    {{-- /Modal includes --}}
@endsection
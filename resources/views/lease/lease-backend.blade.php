@extends('layouts.backend')

@section('title')
    <h1> @lang('lease.page-backend-title-index')
        <small> @lang('lease.backend-sub-title-index') </small>
    </h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('backend') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">@lang('lease.page-backend-title-index')</li>
    </ol>
@endsection

@section('content')
    <div class="box"> {{-- Default box --}}
        <div class="box-header with-border">
            <h3 class="box-title">@lang('lease.title-box')</h3>

            <div class="pull-right">
                @if ((int) count($leases) > 0)
                    <a class="label label-danger" href="{{ route('lease.export') }}">@lang('lease.btn-backend-export')</a> 
                @endif
                
                <a class="label label-danger" href="#" data-toggle="modal" data-target="#create-lease">@lang('lease.btn-backend-add')</a>
            </div>
        </div>

        <div class="box-body">
            @if ((int) count($leases) === 0)
                <div class="alert alert-info alert-important" role="alert">
                    <strong>
                        <span class="fa fa-info-circle" aria-hidden="true"></span> Info:
                    </strong>

                    Er zijn geen verhuringen gevonden in het systeem.
                </div>
            @else
                <div class="table-responsive">
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

                                        <a href="{{ route('lease.delete', ['id' => $lease->id]) }}" class="label label-danger">@lang('lease.btn-backend-delete')</a>
                                    </td> {{-- /Options --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $leases->render() }} {{-- Pagination --}}
                </div>
            @endif
        </div> {{-- /.box-body --}}
    </div> {{-- /.box --}}

    {{-- Modal includes --}}
        @include('lease.backend-create')
    {{-- /Modal includes --}}
@endsection
@extends('layouts.backend')

@section('title')
    <h1> Backend
        <small> beheers paneel </small>
    </h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('backend') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Backend</li>
    </ol>
@endsection

@section('content')
    <div class="row">

        <div class="col-lg-3 col-xs-6"> {{-- Lease info module --}}
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $countLease }}</h3>
                    <p>Verhuringen</p>
                </div>
                <div class="icon">
                    <i class="fa fa-home"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Meer informatie <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div> {{-- /Lease info module --}}

        <div class="col-lg-3 col-xs-6"> {{-- Login module --}}
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $countUsers }}</h3>
                    <p>Gebruikers</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Meer informatie <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div> {{-- /Login module --}}

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-orange">
                <div class="inner">
                    <h3>{{ $countNews }}</h3>
                    <p>Nieuwsberichten</p>
                </div>
                <div class="icon">
                    <i class="fa fa-newspaper-o"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Meer informatie <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>{{ $countActivity }}</h3>
                    <p>Activiteiten</p>
                </div>
                <div class="icon">
                    <i class="fa fa-calendar"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Meer informatie <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="box box-primary collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Recently Added Products</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    //
                </div>
                <div class="box-footer text-center">
                    <a href="javascript:void(0)" class="uppercase">View All Products</a>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="box box-primary collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Recently Added Products</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    //
                </div>
                <div class="box-footer text-center">
                    <a href="javascript:void(0)" class="uppercase">View All Products</a>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="box box-primary collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Recently Added Products</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    //
                </div>
                <div class="box-footer text-center">
                    <a href="javascript:void(0)" class="uppercase">View All Products</a>
                </div>
            </div>
        </div>
    </div>
@endsection
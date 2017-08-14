@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <img class="img-rounded img-front" src="{{ asset('img/front.jpg') }}">
            </div>
        </div>

        <div class="row row-padding-top">
            <div class="col-md-12"> {{-- CONTENT --}}
                <div class="panel panel-default">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-header" style="margin-top: -20px;">
                                    <h2 style="margin-bottom: -5px;">Foto's</h2>
                                </div>
                            </div>

                            <div class="col-md-9"> {{-- Content (section) --}}
                                <div class="row">
                                    @if (count($photos) == 0) {{-- There are no photos in the system. --}}
                                        <div class="col-md-12">
                                            <div class="alert alert-info alert-important" role="alert">
                                                <strong><span class="fa fa-info-circle" aria-hidden="true"></span> Info:</strong>
                                                Er zijn geen foto's van de groep gevonden.
                                            </div>
                                        </div>
                                    @else {{-- There are photos in the system.  --}}
                                        @foreach ($photos as $photo)
                                            <div class="col-md-4">
                                                <div class="thumbnail">
                                                    <div class="caption">
                                                        <h4>{{ $photo->title }}</h4>
                                                        <p>{{ str_limit($photo->description, 75, '...') }}</p>
                                                        <p>
                                                            <a href="{{ $photo->url }}" target="_blank" class="label label-danger">Ga naar album</a>
                                                        </p>
                                                    </div>
                                                    <img src="{{ asset($photo->image_path) }}" style="height:100%; width:100%;" alt="{{ $photo->title }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div> {{-- END Content (section) --}}

                            <div class="col-md-3"> {{-- Sidebar --}}
                                <div class="list-group">
                                    @foreach($groups as $group) {{-- Loop through the groups --}}
                                        <a href="{{ route('photos.groups', ['selector' => $group->id]) }}" class="list-group-item">
                                            <span class="fa fa-picture-o" aria-hidden="true"></span> {{ $group->title }}
                                        </a>
                                    @endforeach {{-- END group loop --}}
                                </div>
                            </div> {{-- END sidebar --}}
                        </div>

                    </div>
                </div>
            </div> {{-- END CONTENT --}}
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .thumbnail {
            position:relative;
            overflow:hidden;
        }

        .caption {
            position:absolute;
            top:0;
            right:0;
            background:rgba(66, 139, 202, 0.75);
            width:100%;
            height:100%;
            padding:2%;
            display: none;
            text-align:center;
            color:#fff !important;
            z-index:2;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $( document ).ready(function() {
            $("[rel='tooltip']").tooltip();

            $('.thumbnail').hover(
                function(){
                    $(this).find('.caption').slideDown(250); //.fadeIn(250)
                },
                function(){
                    $(this).find('.caption').slideUp(250); //.fadeOut(205)
                }
            );
        });
    </script>
@endpush
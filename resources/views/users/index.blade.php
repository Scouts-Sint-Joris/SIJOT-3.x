@extends('layouts.backend')

@section('title')
    <h1> Gebruikersbeheer <small>(Access Control List)</small></h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('backend') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Gebruikers</li>
    </ol>
@endsection

@section('extra-js')
    <script src="{{ asset('js/crud.js') }}"></script>
@endsection

@section('content')
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab"><span class="fa fa-users" aria-hidden="true"></span> Gebruikers</a></li>
            <li><a href="#tab_2" data-toggle="tab"><span class="fa fa-key" aria-hidden="true"></span> Rechten</a></li>
            <li><a href="#tab_3" data-toggle="tab"><span class="fa fa-key" aria-hidden="true"></span> Permissies</a></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <span class="fa fa-btn fa-plus" aria-hidden="true"></span> Toevoegen <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="#" data-toggle="modal" data-target="#create-user">
                            <span class="fa fa-user" aria-hidden="true"></span>Gebruiker
                        </a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="#" data-toggle="modal" data-target="#create-role">
                            <span class="fa fa-key" aria-hidden="true"></span>Rechten
                        </a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="#" data-toggle="modal" data-target="#create-permissions">
                            <span class="fa fa-key" aria-hidden="true"></span>Permissies
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div class="table-responsive">
                    <table class="table table-hover table-condensed table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Status:</th>
                                <th>Naam:</th>
                                <th>Email:</th>
                                <th>Laatst gewijzigd:</th>
                                <th colspan="2">Aangemaakt op:</th> {{-- Colspan="2" needed because the functions. --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td><code><strong>#{{ $user->id }}</strong></code></td>
                                    <td> {{-- User status --}}
                                        @if ($user->isBanned()) <span class="label label-warning">Geblokkeerd</span> @endif
                                        @if ($user->isOnline()) <span class="label label-success">Online</span>
                                        @else
                                            <span class="label label-danger">Offline</span>
                                        @endif
                                    </td> {{-- /User status --}}
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->updated_at->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $user->created_at->format('d/m/Y H:i:s') }}</td>

                                    <td> {{-- Options --}}
                                        @if ($user->isBanned())
                                            <a href="{{ route('users.unblock', $user) }}" class="label label-danger">Deblokkeer gebruiker</a>
                                        @else
                                            <a href="#" onclick="getUser('{{ route('users.getId', $user->id) }}', '#block-user')" class="label label-danger">Blokkeer gebruiker</a>
                                        @endif

                                        <a class="label label-danger" href="{{ route('acl.user.change', $user) }}">Wijzig rechten</a>
                                        <a class="label label-danger" href="{{ route('users.delete', $user) }}">Verwijder</a>
                                    </td> {{-- /Options --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2"> {{-- Roles --}}
                @if ((int) count($roles) === 0)
                    <div class="alert alert-info">
                        <h4><i class="icon fa fa-info-circle"></i> Info!</h4>
                        Er zijn geen rechten gevonden in het systeem.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table-hover table-responsive table-striped table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Naam:</th>
                                    <th>Beschrijving:</th>
                                    <th colspan="2">Aangemaakt op:</th> {{-- Colspan="2" needed for the functions. --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role) {{-- Loop through the roles --}}
                                    <tr>
                                        <td><strong><code>#{{ $role->id  }}</code></strong></td>
                                        <td>{{ ucfirst($role->name) }}</td>
                                        <td>@if (is_null($role->description)) Geen beschrijving gegeven. @else {{ ucfirst($role->description) }} @endif</td>
                                        <td>@if (is_null($role->created_at)) N/A @else {{ ucfirst($role->created_at) }} @endif</td>

                                        <td class="text-center"> {{-- Options --}}
                                            <a href="{{ route('acl.wijzig', ['type' => 'role', 'id' => $role->id]) }}" class="label label-warning">Wijzig</a>
                                            <a href="{{ route('roles.delete', $role) }}" class="label label-danger"> Verwijder </a>
                                        </td> {{-- /Options --}}
                                    </tr>
                                @endforeach {{-- /END loop --}}
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <!-- /.tab-pane -->

            <div class="tab-pane" id="tab_3"> {{-- Permissions --}}
                @if ((int) count($permissions) === 0)
                    <div class="alert alert-info">
                        <h4><i class="icon fa fa-info-circle"></i> Info!</h4>
                        Er zijn geen permissions gevonden in het systeem.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table-hover table-responsive table-striped table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Naam:</th>
                                    <th>Beschrijving:</th>
                                    <th colspan="2">Aangemaakt op:</th> {{-- Colspan="2" needed for the functions. --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission) {{-- Loop trough the permissions --}}
                                    <tr>
                                        <td><code><strong>#{{ $permission->id }}</strong></code></td>
                                        <td>{{ ucfirst($permission->name) }}</td>
                                        <td>@if (is_null($permission->description)) Geen beschrijving gegeven. @else {{ ucfirst($permission->description) }} @endif</td>
                                        <td>@if (is_null($permission->created_at)) N/A @else {{ $permission->created_at }} @endif</td>

                                        <td class="text-center"> {{-- Options --}}
                                            <a href="{{ route('acl.wijzig', ['type' => 'permissions', 'id' => $permission->type]) }}" class="label label-warning">Wijzig</a>
                                            <a href="{{ route('permissions.delete', $permission) }}" class="label label-danger">Verwijder</a>
                                        </td> {{-- /Options --}}
                                    </tr>
                                @endforeach {{-- End permissions loop. --}}
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
    </div>

    {{-- Modals --}}
        @include('users.modals.create')
        @include('users.modals.block')
        @include('users.modals.new-permissions')
        @include('users.modals.new-role')
    {{-- /Modals --}}
@endsection
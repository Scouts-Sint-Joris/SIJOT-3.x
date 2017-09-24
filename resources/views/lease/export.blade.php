<html lang="en">
    <head>
        <title>Alle verhuringen.</title>

        <link rel="stylesheet" href="{{ asset('css/lease-export.css') }}">
    </head>
    <body>

        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>Start datum:</th>
                <th>Eind datum:</th>
                <th>Status:</th>
                <th>Groep:</th>
                <th>Email:</th>
                <th>Tel. Nummer:</th>
            </tr>
            </thead>
            <tbody>
                @foreach($all as $rental)
                    <tr>
                        <td><strong>#{!! $rental->id !!}</strong></td>
                        <td>{{ date('d/m/Y', strtotime($rental->start_datum)) }}</td>
                        <td>{{ date('d/m/Y', strtotime($rental->eind_datum)) }}</td>

                        <td> {{-- Status indication --}}
                            @if ((int) $rental->status_id === 1)
                                Nieuwe aanvraag
                            @elseif ((int) $rental->status_id === 2)
                                Optie
                            @elseif ((int) $rental->status_id === 3)
                                Bevestigd
                            @endif
                        </td> {{-- /Status indication --}}

                        <td>{{ $rental->groeps_naam }}</td>
                        <td>{{ $rental->contact_email }}</td>

                        <td>
                            @if (empty($rental->tel_nummer))
                                Niet opgegeven
                            @else
                                {{ $rental->tel_nummer }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
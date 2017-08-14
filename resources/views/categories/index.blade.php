@if ((int) count($categories) > 0)
    <div class="table-responsive">
        <table class="table table-condensed table-hover table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Aangemaakt door:</th>
                    <th>Naam:</th>
                    <th>Beschrijving:</th>
                    <th>Aantal berichten:</th>
                    <th>Aangemaakt op:</th> {{-- Colspan="2" needed for the functions. --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td><strong>#{{ $category->id }}</strong></td>
                        <td>{{ $category->author->name }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td><span class="label label-info">{{ count($category->news) . ' berichten' }}</span></td>
                        <td>{{ $category->created_at }}</td>

                        <td class="pull-right"> {{-- Options --}}
                            <a href="" class="label label-warning">Wijzig</a>
                            <a href="{{ route('category.delete', $category) }}" class="label label-danger">Verwijder</a>
                        </td> {{-- /Options --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="alert alert-info alert-important" role="alert">
        <strong><span class="fa fa-info-circle" aria-hidden="true"></span> Info:</strong>
        Er zijn geen nieuws categorieen in het systeem gevonden.
    </div>
@endif
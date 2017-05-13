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
                    <th>Aangemaakt op:</th>
                    <th>Laatst gewijzigd:</th>
                </tr>
            </thead>
        </table>
    </div>
@else
    <div class="alert alert-info alert-important" role="alert">
        <strong><span class="fa fa-info-circle" aria-hidden="true"></span> Info:</strong>
        Er zijn geen nieuws categorieen in het systeem gevonden.
    </div>
@endif
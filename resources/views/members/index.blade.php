@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <img class="img-rounded img-front" src="{{ asset('img/front.jpg') }}">
            </div>
        </div>

        <div class="row row-padding-top">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12"> {{-- Page header --}}
                                <div style="margin-top: -20px;" class="page-header">
                                    <h2 style="margin-bottom: -5px;">Lid worden</h2>
                                </div>
                            </div> {{-- /Page header --}}
                        </div>

                        <div class="row">
                            <div class="col-md-12"> {{-- Content --}}
                                <h4>Lidgeld</h4>

                                <p>
                                    Dit jaar bedraagt het lidgeld €35. Dit is de standaardprijs van Scouts en Gidsen Vlaanderen,
                                    Daarboven op wragen wij nog is €2 werkingsgeld. Aansluiten (lidgeld betalen) bij Scouts en
                                    Gidsen Vlaanderen betekent verzekerd zijn op alle activiteiten van de scouts.
                                </p>

                                <p>
                                    He betalen via overschrijving: BE00 0000 0000 0000. Vermeld in de mededeling van de
                                    overschrijving van het lidgeld zeker naam, voornaam en tak (die mag u afkorten naar
                                    KAP, W, K, JV, JG, V, G of J) va je zoon/dochter.
                                </p>

                                <p>
                                    Wij hopen dat deze en andere kosten van scouting betaalbaar zijn. Mocht dat niet zo zijn,
                                    dan zoeken wij in alle vertrouwen graag mee naar een oplossing hiervoor.
                                </p>

                                <p style="padding-bottom: 10px;">
                                    <a href="https://groepsadmin.scoutsengidsenvlaanderen.be/groepsadmin/lidworden?groep=A4102G" class="btn btn-primary btn-sm">Inschrijven</a>
                                </p>

                                <h4>Lid worden</h4>

                                <p>
                                    Via deze links kan u online inschrijven. Uw aanvraag zal dan door de groepsleiding goedgekeurd worden.
                                    Na uw inschrijving dient u ook lidgeld te betalen (zie hierboven). Het is zeker niet nodig om voor
                                    (of na) de eerste vergadering in te schrijven en lidgeld te betalen. Elk nieuw lid kan tot
                                    3 keer mee spelen zonder in te schrijven.
                                </p>

                                <h4>Uniform</h4>

                                <p>
                                    Het <a href="https://www.scoutsengidsenvlaanderen.be/ik-wil-naar-de-scouts/het-uniform">Uniform</a> 
                                    bestaat ui een das, een beige hemd of trui (optioneel). En een groene korte broek of rok. Bij de 
                                    kapoenen is enkel de das verplicht. Vandaf de welpen is het das, hemd en broek. De das kan je kopen 
                                    bij de leiding, de rest van het uniform is te verkrijgen bij de
                                    <a href="https://www.hopper.be/winkel/webshop/kleding-uniform-scouts-en-gidsen-c-9_10.html">Hopper winkels.</a>
                                </p>

                                <h4>Verminderd lidgeld.</h4>

                                <p>
                                    We vragen jaarlijks om voor elk kind lidgeld te betalen. Dankzj dit bedrag is uw zoon/dochter verzekerd
                                    tijdens scoutsactiviteiten. Een ander deel van dit bedrag gaat naar het maken en verzenden van de tijdschriften
                                    voor leiding en leden, en de algemene werkingskosten. We begrijpen dat dit lidgeld voor u misschien een groot
                                    bedrag is om te betalen. Wij hebben de mogelijkheid om hierop een korting an te bieden, voor wie dit echt nodig heeft.
                                    Spreek hiervoor simpelweg een (groeps)leid(st)er aan!
                                </p>

                                <h4>Voordelen bij ziekenfondsen</h4>

                                <p>
                                    Mutualiteiten dragen vaak ook bij aan de kosten van vrijetijdsbesteding van uw kinderen. Welke voordelen
                                    dit precies zijn, hangt af van welk ziekenfonds u bent. Ga gerust eens langs bij het lokale kantoor van
                                    uw mutualiteit en vraag na op welke voordelen u recht hebt.
                                </p>

                                <h4>Belastingvoordelen</h4>

                                <p>
                                    De kosten voor kampen en weekends van allen kinderen jonger dan 12 jaar of kinderen met een
                                    zware handicap jonger dan 18,
                                    kan door middel van een fiscaal attest afgetrokken worden van van de belastingen.
                                    Hiervoor moet de (groeps)leiding het 'Attast inzake uitgaven voor de opvang van kinderen' invullen en
                                    aan u bezorgen. U moet dit formulier dan bij uw belastigaangifte voegen. Als u dit formulier nog niet
                                    gekregen heeft van de scoutsleiding, vraag hen er dan tijdig naar. Meer info vindt u
                                    <a href="https://www.scoutsengidsenvlaanderen.be/files/paginas/actie/kamp_of_weekend/regels_en_afspraken/kamp_of_weekend_fiscaal_aftrekbaar/2010.05.17_fiscale_aftrekbaarheid.pdf">hier</a>.
                                </p>
                            </div> {{-- Content --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('layouts.modules.footer')
@endsection
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
                                    <h2 style="margin-bottom: -5px;">Disclaimer</h2>
                                </div>
                            </div> {{-- /Page header --}}
                        </div>

                        <div class="row">
                            <div class="col-md-12"> {{-- Content --}}
                                <h4>Algemeen:</h4>

                                <p>
                                    Scouts en Gidsen Sint-Joris neemt je privacy eserieus. Lees het volgende voor meer
                                    informatie over ons privacybeleid.
                                </p>

                                <p>
                                    Scouts en Gidsen Sint-Joris hecht waarde aan de bescherming van je persoonlijke gegevens.
                                    Door gebruik te maken van onze wesbite, aanvaard he daarmee gebonden te zijn aan deze
                                    privacy policy, die kan worden gewijzigd of aangepast van tijd tot tijd zonder
                                    voorafgaande kennisgeving.
                                </p>

                                <h4>Traffic data: (Automatich Gegenereerde Informatie)</h4>

                                <p>
                                    Traffic data worden gegenereerd wanneer je computer verbinding maakt met de website van
                                    Scouts en Gidsen Sint-Joris, en zijn niet voldoende alleen om je te identificeren. We
                                    kunnen de volgende informatie verzamelen: de oorsprong van de verbinding, IP-adres,
                                    het type en de versie van je internet browser, de lengte van de verbinding, enz. Deze
                                    gegevens kunnen worden gebruikt voor statische doeleinden om het verkeer naar en naar
                                    <a href="http://www.st-joris-turnhout.be">st-joris-turnhout.be</a> te analyseren
                                    (meest en minst bekeken pagina's, activiteit per dag en uur, enz.).
                                    Traffic data worden altijd anoniem verwerkt.
                                </p>

                                <h4>Cookies:</h4>

                                <p>
                                    Cookies zijn kleine beetjes informatie die onze server naar jouw browser stuurt met
                                    de bedoeling dat deze informatie bij een volgend bezoek weer naar onze server teruggestuurd
                                    wordt. Deze kleine tekstbestanden worden opgeslagen op de harde schijf of in het geheugen
                                    van je computer.
                                </p>

                                <p>
                                    In de cookies wordt informatie opgeslagen (zoals de instellingen van jouw computer en door
                                    jouw aangegeven voorkeuren) om een volgend gebruik van deze website te vergemakkelijken.
                                    Deze informatie bevat naast je IP-adres, geen naam- of adresgegevens of andere persoonlijke
                                    gegevens. Je kunt jouw browser zo installen dat je tijdens je volgende gebruik van de website
                                    geen cookies otvangt. In dat geval kan het echter gebeuren dat je niet gebruik kunt maken van alle
                                    mogelijkeheden van de website of dat je geen toegang hebt tot (onderdelen van) deze website.
                                </p>

                                <h4>Persoonsgegevens:</h4>

                                <p>
                                    Je hoeft ons niet te voorzien van persoonlijk identificeerbare informatie on onze wbesite te gebruiken.
                                    ALs we enige persoonlijke informatie ontvangen, verzamelen en/of verwerken, gebruiken we het op een
                                    eerlijke of rechtmatige wijze. Wij zullen nooit je persoonlijke informatie delen met derden.
                                </p>

                                <h4>Informatie op de website:</h4>

                                <p>
                                    Wij kunnen niet garanderen dat de informatie op onze website foutloos is, volledig en/of actueel is.
                                    Daarom kunt u aan de informatie op deze website geen rechten ontlenen. Evenmin zijn wij aansprakelijk voor schade
                                    als gevolg van deze onjustheden en/of gedateerde informatie. Mocht u informatie, data en/of programma's tegen komen
                                    waarvan het copyright bij u ligt, verzoeken we dit te melden aan de webmaster.
                                </p>

                                <p>
                                    Indien u informatie tegenkomt die un uw ogen niet goed, volledig of actueel is, kunt u contact opnemen
                                    ùet de webmaster of leiding. Wij stellen uw commentaar en/of eventuele aanvullingen op prijs. Door uw bijdragen kunnen
                                    wij onze website verbeteren.
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
@component('mail::message')
# U hebt een nieuwe verhuring aangevraagd.

Bedankt voor uw intresse in ons. Met deze mail heeft u een bevestiging dat uw aanvraag goed is doorgekomen.

Hier zijn alle gegevens nog is.
Indien u deze verhuring niet hebt aangevraagd of de gegevens foutief zijn. Kunt u zich wenden tot Verhuur@st-joris-turnhout.be

@component('mail::table')

    |                |                               |
    | -------------- | ----------------------------: |
    | Start datum:   | {{ date("d-m-Y", strtotime($data['start_datum'])) }}      |
    | Eind datum:    | {{ date("d-m-Y", strtotime($data['eind_datum'])) }}       |
    | Groep:         | {{ $data['groeps_naam'] }}      |
    | Contact email: | {{ $data['contact_email'] }}    |
    | Contact gsm:   | {{ $data['tel_nummer'] or 'Niet opgegeven' }}       |

@endcomponent

Met vriendelijke groet,<br>
{{ config('app.name') }}
@endcomponent
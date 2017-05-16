@component('mail::message')
# Nieuwe aanvraag

Er is een nieuwe verhuring aangevraagd.

@component('mail::table')

|                |                               |
| -------------- | ----------------------------: |
| Start datum:   | {{ date("d-m-Y", strtotime($data['start_datum'])) }}      |
| Eind datum:    | {{ date("d-m-Y", strtotime($data['eind_datum'])) }}       |
| Groep:         | {{ $data['groeps_naam'] }}      |
| Contact email: | {{ $data['contact_email'] }}    |
| Contact gsm:   | {{ $data['tel_nummer'] or 'Niet opgegeven' }}       |

@endcomponent

@component('mail::button', ['url' => 'http://www.st-joris-turnhout.be'])
    Bekijk verhuring
@endcomponent

Met vriendelijke groet,<br>
Scouts en Gidsen - Sint-Joris
@endcomponent
@component('mail::message')
# Uw login

Er is voor u een login aangemaakt. u kunt met het onderstaande email adres en wachtwoord inloggen.

@component('mail::table')

|                |                               |
| -------------- | ----------------------------: |
| Naam:          | {{ $data['name'] }} |
| Email:         | {{ $data['email'] }}  |
| Wachtwoord:    | {{ $data['password'] }} |

@endcomponent

@component('mail::button', ['url' => 'http://www.st-joris-turnhout.be'])
Aanmelden
@endcomponent

Met vriendelijke groet,<br>
Scouts en Gidsen - Sint-Joris
@endcomponent
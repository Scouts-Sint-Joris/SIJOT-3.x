# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

# Version 0.2.0
- fixed #27: Implementeer travis hook
- Added model factories. 
- Fix: formulier validatie bij de groeps wijziging. 
- Fix: probleem dat groepen niet aangepast konden worden.
- Fix: fout in doc blocks -> leasecontroller.
- Added: Implementeer test voor de lid-worden route.
- Fix: Implementatie open graph. (website makkelijker te vinden op facebook.)
- Verhurings datum worden nu gesorteerd op welke aanvraag recent begint. 
- Er is nu een cronjob ingesteld voor automatische onderhouds taken. (MySQL backups)
- De server word nu gemonitord door een cronjob. (uptime, ssl certificaten, disk quota's)
- Implementatie van een readme bestand.
- Tail commando geimplementeerd (`php artisan tail production`). Voor het lezen van de logs op externe plaatsen.
- Implementatie van een nieuwe disclaimer.
- Implementatie systeem translatie bestanden. (NL, ENG)
- Fix: Verdwaalde karakter `)` in de verhurings export verwijderd.
- Implementatie abbrivetaties bij de tak afkortingen.
- Implementatie code of conduct. 
- Implementatie om gebruikers via de GUI te verwijderen.
- Bugfix in de `getById()` methode van de gebruikers controller.
- Implementatie deblokkerings methode voor gebruikers.
- Class docblock toegevoegd op de Users model.
- Class docblock toegevoegd op de NewsController

# Version 0.1.0

- Initial release

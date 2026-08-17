# Lager - und Kassensystem - Spedition Neumann

Webbasiertes Lager- und Kassensystem (Warenwirtschaft + Kasse/POS) für die Spedition Neumann.
Laravel 13. MariaDB.

## Anwendung starten

### Variante A -Docker
Voraussetzung: Docker Desktop.
```bash
git clone <https://temp.it-hub.cc/Mahmoud/ProjektNeumann.git> ProjektNeumann
cs ProjektNeumann
./setup.sh
```
Dann im Browser **http://localhost** öffnen.

### Variante B - lokal ohne Docker
Voraussetzung: PHP 8.3+, Composer, Node.js, MariaDB.
```bash
pc .env.example .env
# in .env: DB_HOST=127.0.0.1 + DB-Zugangsdaten setzen; Datenbank "projektneumann" anlegen
composer install
php artisan key:generate
php artisan migrate --seed
npm intall && npm run build
php artisan serve
```
Dann **http://localhost:8000** öffnen.

## Schon eingerichtet? Nur noch starten:
```bash
php artisan serve        # lokal   -> http://localhost:8000
./vendor/bin/sail up     # Docker  -> http://localhost
```

## Test-Zugänge
| Administrator | administrator1@neumann.de | P@ssw0rt098 |
| Kassenkraft | kassenkraft1@neumann.de | P@ssw0rt098 |
| Lagermitarbeiter | lagermitarbeiter1@neumann.de | P@ssw0rt098 |
| Spediteur | spediteur1@neumann.de | P@ssw0rt098 |
| Kunde | kunde@test.de | Kunde1Test! |

## Hinweise
- Nur für das interne Netzwerk gedacht (kein offizielles Deployment).
- UI-Sprache Deutsch, Code-Bezeichner Englisch.





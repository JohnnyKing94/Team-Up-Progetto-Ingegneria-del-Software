# TEAMUP - By Zoomer Boyz
### Progetto di Ingegneria del Software aa. 2019/2020

>Team Up! vuole andare incontro a tutte le persone che hanno dovuto rinunciare o hanno riscontrato difficoltà nel realizzare i loro progetti, cercando di riunire persone con lo stesso obbiettivo o passione in modo tale da potersi aiutare a vicenda.

### NOTE: Immagini per il documento Report
All'interno del repository è possibile visualizzare le immagini native della documentazione di progetto all'interno della cartella ```.immagini_report```. Le immagini caricate sono i **Mockup**, i **Diagrammi** e gli **screenshot di SonarQube**.

### Live Demo
Una demo del prodotto è disponibile al seguente indirizzo: [gianfrancomossa.com/teamup](https://gianfrancomossa.com/teamup/). I dati di testing sono visualizzabili a fine di questa documentazione.

### Requisiti
* [PHP 7.4.7](https://windows.php.net/downloads/releases/php-7.4.7-nts-Win32-vc15-x64.zip) - Hypertext Preprocessor Safe
* [MySQL Community Server 8.0.20](https://cdn.mysql.com//Downloads/MySQLInstaller/mysql-installer-community-8.0.20.0.msi)
* [Composer 1.10.7](https://getcomposer.org/Composer-Setup.exe) - A Dependency Manager for PHP
* [Node.js 12.18.0 LTS](https://nodejs.org/dist/v12.18.0/node-v12.18.0-x64.msi) - JavaScript runtime built on Chrome's V8 JavaScript engine

### Installazione

1. Scaricare ed estrarre l'archivio di PHP 7.4.7
2. Andare su ```Pannello di Controllo >> Sistema >> Impostazioni di sistema avanzate >> Variabili d'ambiente``` e aggiungere a ```Path``` il percorso della cartella PHP 7.4 (es. ```C:\Users\Nome Utente\Desktop\php-7.4.7-nts-Win32-vc15-x64```)
3. Entrare nella cartella ```php-7.4.7-nts-Win32-vc15-x64```, rinominare ```php.ini-development``` in ```php.ini```
4. Aggiungere questo blocco di estensioni all'interno del file ```php.ini```
```
extension=php_fileinfo.dll
extension=php_gd2.dll
extension=php_curl.dll
extension=php_mbstring.dll
extension=php_openssl.dll
extension=php_pdo_mysql.dll
extension=php_pdo_sqlite.dll
extension=php_sockets.dll
```
5. Decommentare ```extension_dir``` e specifiare il percorso della cartella "ext" all'interno del file (es. ```extension_dir = "ext"```)
6. Scaricare ed installare MySQL Community Server 8.0.20, la versione Installer MSI specificando il tipo di installazione "custom" indicando solo il pacchetto MySQL Server
    * Note: durante l'installazione, quando richiesto, scegliere come opzione la versione standalone MySQL Server, come Config Type: Development Computer e il resto delle opzioni invariato eccetto la specifica della password.
7. Avviare MySQL 8.0 Command Line Client, connetersi ed eseguire il seguente comando: ```CREATE DATABASE teamup;```
8. Scaricare ed installare Composer 1.10.7 senza spuntare il Developer Mode
9. Scaricare ed installare Node.js 12.18.0 LTS lasciando le opzionalità invariate
10. Scaricare il repository di **Team Up - Zoomer Boys**
11. Creare il file ```.env``` e copiarne il seguente contenuto
    * Impostare i dati di connessione a MySQL. Se si vuole usufruire del servizio **MAIL** per il *Reset della password*, si richiede la registrazione gratuita di un account a un servizio di Email Delivery Service~ quale SendGrid, Amazon SES, Mandrill o Mailgun.
```
APP_NAME=TeamUp
APP_ENV=local
APP_KEY=
APP_DEBUG=false
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=teamup
DB_USERNAME=root
DB_PASSWORD=password

BROADCAST_DRIVER=pusher
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=anyID
PUSHER_APP_KEY=anyKey
PUSHER_APP_SECRET=anySecret
PUSHER_APP_CLUSTER=eu

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

MIX_APP_ENV="${APP_ENV}"
```
12. Avviare il prompt dei comandi posizionato nella cartella del codice di Team Up ed eseguire i seguenti comandi:
```
php artisan key:generate
composer install --optimize-autoloader --no-dev
npm install
npm run production
php artisan cache:clear
php artisan config:clear
php artisan config:cache
php artisan view:cache
php artisan migrate:fresh --seed
```
13. Lanciare il seguente comando sulla stessa finestra del prompt (**e lasciatelo in esecuzione**):
```
php artisan serve
```
14. In un altro promp dei comandi posizionato sempre nella cartella del codice di Team UP, eseguire quest'ultimo comando (**e anche questo lasciatelo in esecuzione**):
```
php artisan websocket:serve --port 6080
```
   * Se vi appare un avviso di Sicurezza di **Windows Defender Firewall**, consetitegli l'accesso

### Dati default
Per la connessione alla piattaforma, vengono rilasciati di default i seguenti account di testing:

**ADMIN**

system@email.com : password


**USER**

test1@email.com : password

test2@email.com : password

test3@email.com : password

test4@email.com : password


### Pagine di download

| Prodotto | Link |
| ------ | ------ |
| PHP 7.4.7 | [windows.php.net/download#php-7.4](https://windows.php.net/download#php-7.4) |
| MySQL Community Server 8.0.20 | [dev.mysql.com/downloads/mysql/](https://dev.mysql.com/downloads/mysql/) |
| Composer 1.10.7 | [getcomposer.org/download/](https://getcomposer.org/download/) |
| Node.js 12.18.0 LTS | [nodejs.org/it/](https://nodejs.org/it/) |


Licenza
----

MIT

**Free Software, Hell Yeah!**

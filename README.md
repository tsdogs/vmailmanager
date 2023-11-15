vmailmanager
===========
vmailmanager is a Postfix / Dovecot / Sogo Account management web panel. It manages a MySQL User Account database.

SETTING UP THE SERVER
---------------------
This guide is one of the best I've found on the internet.
<https://thomas-leister.de/en/mailserver-debian-stretch/>


INSTALLATION
------------

It's a PHP Yii2 Application. 
Instructions will be available soon, but basically follow a Yii2 application installation
You need Apache or Nginx with PHP installed

put this application in some path for the web server to publish it:
/srv/vmailmanager 
should be a good choice

Be sure to have composer 

Change the config/db.php (copy the config/db.php.example and change accordingly)

composer install 
./yii migrate

Setup apache or nginx and head to: http://Server IP/vmailmanager/

Have also a look to the "doc" folder which contains configurations examples for Postfix / Dovecot and Sogo

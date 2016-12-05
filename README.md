# pos
Simple pos (point of sale) system for HND

Install
-------------------------------------------------------------------------------------------------
First you have to install composer to your system ( https://getcomposer.org/ )

(If your wroking on localhost in windows, you have to add php into the environmental variables)

Then run "composer install"

After installing all dependencies, run "composer dump-autoload -o" in your terminal

Configure
--------------------------------------------------------------------------------------------------
In this application all configurations are writes in the config.php (system/config/config.php)

1. app => url is the main url for the application ( ex: http://localhost:8080/pos/' )
2. if your using mysql then you have to add mysql database credentials to the config.php and change 'db' => 'type' into mysql




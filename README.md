# Logiciel de gestion des commandes pour le Fablab

## Description

TODO

## Installation

### Laravel framework installation

#### Versions utilisées

| Tool | Version |
|-------|---------|
| PHP | 8.1.3 |
| Composer | 2.2.6 |
| Laravel | 9.3 |
| MySQL | 8.0.22 | 

#### PHP Installation

https://thishosting.rocks/install-php-on-ubuntu/

php.ini
````
sudo apt install openssl php-common php-curl php-json php-mbstring php-mysql php-xml php-zip
````

#### Composer installation
https://getcomposer.org/doc/00-intro.md

Under Windows part:
https://getcomposer.org/Composer-Setup.exe


````
sudo apt-get upgrade
````

````	
sudo apt-get install php
````

````
php --version
````

Under Linux part:
````
curl -sS https://getcomposer.org/installer | php
````

#### Laravel configuration

##### File _php.ini_ configuration

uncomment line `;extension=php_fileinfo.dll` from file php.ini

Found where extensions are indicated

##### Installation de dépendances via composer et packagist

Dépendances à installer via la commande `composer require [packageName]`:
* composer require league/mime-type-detection
* composer require league/flysystem
* composer require laravel/framework

##### Commande Laravel pour créer un projet
* composer create-project laravel/laravel nomprojet
* 


#### Ajout du projet Vue.js compilé à Laravel pour réaliser un SPA
Pour intégrer la SPA du frontend dans le code du backend, il faut d’abord compiler le
projet. Lors de la compilation, les pages et composants Vue sont traduits en HTML,
CSS et JavaScript. Une fois terminé, le dossier "dist" est rempli avec deux fichiers
et un dossier :
— Le dossier "assets", qui contient les images, les logos, et le code JS et CSS.
— Le fichier "favicon.ico", qui est l’icône qui apparait dans le navigateur.
— Le fichier "index.html", qui contient la page HTML de lancement.
Ces trois éléments du dossier "dist" doivent ensuite être déposés dans le dossier
"public" du backend. Il faut aussi impérativement copier le contenu de "index.html"
pour le mettre dans "resources/views/app.blade.php".

## Use

1. Start by running this command to install dependencies:
````
composer install
````

2. It use Laravel Sail, so go use the following command:
````
./vendor/bin/sail up
````

3. You can also create an alias for _sail_ like that:
````
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
````

4. Copy the .env.example and adapt it to your needs.

5. Generate your key for the first time:
````
./vendor/bin/sail artisan key:generate
````

6. Run the migrations:
````
./vendor/bin/sail artisan migrate:fresh --seed

./vendor/bin/sail artisan migrate
````

7. Run the seeds:
````
./vendor/bin/sail artisan db:seed
````

### Default port
default developement server in on port 80

### Migration
````
./vendor/bin/sail artisan migrate
````

## Tests
````
./vendor/bin/phpunit
````
or
````
./vendor/bin/sail artisan test
````

### Test coverage
Not unable yet!
````
./vendor/bin/sail artisan test --coverage
````

## Support

## Contribute

## Authors

* Chevallier Yves
* Berney Alec
* Lieberherr Tristan
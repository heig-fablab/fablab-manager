# FabLab Manager

## Lancement projet en fonction de l'OS

### Windows
https://laravel.com/docs/9.x/installation#getting-started-on-windows

````
cd example-app
 
./vendor/bin/sail up
````

## Sail
https://laravel.com/docs/9.x/sail

alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'

sail up

sail stop

### reprise du git
````
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
````
# Software about order management for the HEIG-VD Fablab

[![Test Coverage](https://raw.githubusercontent.com/heig-fablab/fablab-manager/main/badge-coverage.svg)](https://packagist.org/packages/heig-fablab/fablab-manager)

## Description
The Fablab is a laboratory of the HEIG-VD school where mainly students can realize
all kinds of works with the help of machines / devices or others. 
These works are generally requested by students to technicians / experts. 
The management of these requests does not suit the fablab managers and a dedicated web platform to manage these requests has already been the subject of a previous Bachelor thesis.
As the application is not totally finished and deployed, a fresh Bachelor thesis has been proposed in order to improve and complete it.

The final web platform will allow a better management of exchanges and orders.
It will also provide a new dimension to the tracking and administration of the laboratory.

A clear procedure from the request to the realization of the requested work will also be implemented through this application.

To facilitate the follow-up of customer requests, the platform will set up a notification system by email and on the application itself.

As the web tool is intended to reach school users, authentication via a school authentication (HEIG or Switch edu-id) tool will be provided.

## Installation & Use

No installation is needed, you just need to run your favorite browser and go to the following link:\
http://tb22-berney.heig-vd.ch/

## Contribute
To contribute to this project, you need to install a few dependencies that we will explain later.

### Dev environment installation

#### Dependencies

| Tool           | Version |
|----------------|---------|
| PHP            | 8.1.8   |
| Composer       | 2.3.9   |
| Laravel        | 9.2     |
| Laravel Sail   | 1.0.1   |
| Docker Desktop | 4.10.1  |
| WSL Ubuntu     | 20.04   |


#### Docker / Docker desktop / Docker compose
First thing to do is to install Docker on Linux or Docker Desktop on Windows.

##### WSL 2.0
If you are running Windows as OS, you need to install WSL 2.0. \
Here is a link to the documentation: https://docs.microsoft.com/en-us/windows/wsl/install

Here is how you can use Docker and WSL 2 together:
https://docs.docker.com/desktop/windows/wsl/

If you want to not use sudo to use Docker commands: https://docs.docker.com/engine/install/linux-postinstall/

###### WSL Possible problems
You'll perhaps have CRLF / LF problems. To avoid them you can use the following commands:
````
sudo git config core.autocrlf false 
git rm --cached -r .
git config --global --add safe.directory /home/<username>/<path>/fablab-manager
git reset --hard
sudo chown -R <username> fablab-manager/
````

#### PHP
Now you have Docker installed and have a Linux or WSL running, you need to install PHP on your Linux or WSL.

Here is a nice link to help you: https://computingforgeeks.com/how-to-install-php-on-ubuntu-linux-system/

You need to care to have the following extensions installed:
* BCMath
* Ctype
* Fileinfo
* JSON
* Mbstring
* OpenSSL
* PDO
* Tokenizer
* XML

#### Composer
Now you've installed php, you need to install Composer on your Linux or WSL.

Here is a link to install it: https://getcomposer.org/doc/00-intro.md

You can also run this command:
````
sudo apt-get install composer
````

You'll perhaps need to add some permissions (you are in project folder):
````
sudo chmod 777 /home/<username>/tb/fablab-manager/
sudo chmod -R 777 storage
sudo chmod -R 777 bootstrap/
````

### Run Laravel project

1. Be sure you are in the project freshly cloned.
````
cd fablab-manager
````

2. Start by running this command to install dependencies:
````
composer install
````

3. Get the sail environment ready:
````
cp .env.dev.example .env
````

4. Add public key given by manager **Yves Chevallier** to the .env variable:
````
KEYCLOAK_REALM_PUBLIC_KEY=
````

5. Project use Laravel Sail, to start it, run the following command:
````
vendor/bin/sail up -d
````
or
````
./vendor/bin/sail up -d
````

6. Generate your key for the first time:
````
vendor/bin/sail artisan key:generate
````

7. Add category images to storage for seeding:
````
mkdir storage/app/public/images
````
````
cd job-categories-images
````
````
cp cat1.jpg cat2.jpg cat3.jpg cat4.jpg cat5.jpg cat6.jpg cat7.jpg cat8.jpg cat9.jpg cat10.jpg ../storage/app/public/images
````
````
cd ..
````

8. Run the migrations and seeds:
````
vendor/bin/sail artisan migrate:fresh --seed
````

9. Create the link for public storage:
````
vendor/bin/sail artisan storage:link
````

You have now the Laravel backend running!

### Workflow / Git flow
We are using the classic git flow, so if you don't know what i'm speaking about, check the wiki:\
https://github.com/heig-fablab/fablab-manager/wiki/Git-flow \
or in the internet:\
https://blog.bespinian.io/posts/git-the-important-parts/gitflow.png

### Tests
To run all tests you can run the following command:
````
vendor/bin/sail test
````

To run a specific test you can run the following command:
````
vendor/bin/sail test --filter FileName
````

### Mail testing
As we develop with Laravel Sail, the library [MailHog](https://github.com/mailhog/MailHog) is available, 
watch the test mail send at this address: \
http://localhost:8025/

### Websockets
Websockets are used in this project.

If you have a problem with websockets, you can try to run sail like this:
````
vendor/bin/sail up -d --build
````

You can see all websockets movement here: \
http://localhost/laravel-websockets

### Seeders
Seeders already creates all data necessary to make work the program.\
They also create some fake data when you aren't in production environment.

#### Job Category images
You just need to add the job category images in the folder "storage/public/file-storage/cat". \
They must be named: "cat_id.png". \
Job Category has actually 9 entries, so you need to add 9 images.
````
cd job-categories-images
````
````
cp cat1.jpg cat2.jpg cat3.jpg cat4.jpg cat5.jpg cat6.jpg cat7.jpg cat8.jpg cat9.jpg cat10.jpg ../storage/app/public/images
````

### Other usefully things

### IDE Recommendations
I recommend you to use PHP Storm from JetBrains: https://www.jetbrains.com/fr-fr/phpstorm/

Second choice is Visual studio, if it is your case, don't forget to install the extension for:
* Laravel
* PHP

#### Default port
default developement server in on port 80

#### Sail things

##### Sail alias command
You can also create an alias for **sail** command like that:
````
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
````

#### Access container
If you want to access to your running container, use following command:
````
vendor/bin/sail root-shell
````

### Keycloak
TODO

### Postman
To help at testing API, a collaborative [Postman](https://www.postman.com/) exists,
ask **Yves Chevallier** for the link.

## Deployement
Here is what you need to do to deploy the application.

### Add frontend Vue.js compiled to the Laravel one
Go on your frontend project, replace the .env by copying the .env.prod.example:
````
rm .env
cp .env.prod.example .env
````
Build for production with following command:
````
npm run build
````

Then you'll see a dist folder appears at the top of the project files, this one contains the compiled files.\
Then you'll need to copy the files in the dist folder to the Laravel project.
Here are the files and folder in dist folder:
* Folder **assets**, that contains images, logos and JS + CSS code.
* File **favicon.ico**, that is browser icon.
* File **index.html**, that containe HTML page.

Now you need to copy these files to the **public** folder of the Laravel project.

You also need to copy the content of the **index.html** file into the **resources/views/app.blade.php** file.

### Create release on Github
Create a new branch from develop.\
Then, you'll need to push the branch to Github with all the modifications done before.
Create a PR from the release branch to the main and merge it after CI finished.

### Update prod

#### Connect to prod
Connect to the prod using HEIG-VD VPN if you are not in their network. \
Then use the following ssh command replacing the <values>.
````
ssh <user>@<machine>
````

Ask **Yves Chevallier** for the credentials.

#### Update the prod repository
go to :
````
cd /var/www/fablab-manager
````

pull new content:
````
git pull
````

if you have some migrations, execute them:
````
php artisan migrate --path=/database/migrations/full_migration_file_name_migration.php
````

## Support
For support, send an email at this address:
[fablab-manager-support](mailto:yves,chevallier@heig-vd.ch)

## Authors

* Chevallier Yves
* Berney Alec
* Lieberherr Tristan


## Currently writing

### Installation xdebug

````
sudo apt-get install php8.1-xdebug
````

Path php.ini wsl 2:
````
\\wsl.localhost\Ubuntu\etc\php\8.1\cli
````

Add:
````
[xdebug]
zend_extension="<path to xdebug extension>"
xdebug.mode=debug
xdebug.client_host=127.0.0.1
xdebug.client_port="<the port (9003 by default) to which Xdebug connects>"
````

### Test coverage
Not unable yet!

https://laravel.com/docs/9.x/sail#debugging-with-xdebug
(not with sail)
Add the following line to your php.ini file:
````
xdebug.mode=coverage
````

https://laracasts.com/discuss/channels/laravel/laravel-9-code-coverage
https://stackoverflow.com/questions/66876314/laravel-not-generating-code-coverage-report

To run tests with coverage, use this command:
````
vendor/bin/sail test --coverage
````

### Debugging:
https://laravel.com/docs/9.x/sail#xdebug-browser-usage
https://blog.devgenius.io/how-to-enable-xdebug-on-laravel-sail-and-debugging-code-with-vs-code-872fd750b340
https://www.youtube.com/watch?v=Xgn0EtB4chc

Start a debug session:
````
vendor/bin/sail debug
````

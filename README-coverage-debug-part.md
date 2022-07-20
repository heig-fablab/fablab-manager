## Currently writing / implementing / testing

### Installation xdebug
You can also install a tool to debug with break points and other things. \
To do it, install xdebug with the following command:
````
sudo apt-get install php8.1-xdebug
````

Add to php.ini the following line:
````
[xdebug]
zend_extension="<path to xdebug extension>"
xdebug.mode=debug
xdebug.client_host=127.0.0.1
xdebug.client_port="<the port (9003 by default) to which Xdebug connects>"
````

php.ini can be found at this path in WSL2:
````
\\wsl.localhost\Ubuntu\etc\php\8.1\cli
````

### Test coverage
Not available yet!

https://laravel.com/docs/9.x/sail#debugging-with-xdebug \
(not with sail) \
Add the following line to your php.ini file:
````
xdebug.mode=coverage
````

https://laracasts.com/discuss/channels/laravel/laravel-9-code-coverage \
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

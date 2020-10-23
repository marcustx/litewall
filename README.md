In order to run unit tests

First, run the following command to download any libraries defined in the composer.json file:
php composer.phar update

To update autoloader class information run this command;
php composer.phar dump-autoload

To exectute PHPUnit Tests, run this command:
./vendor/bin/phpunit tests

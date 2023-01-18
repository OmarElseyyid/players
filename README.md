# players guide
------------------------------------
# for db migrations
composer require robmorgan/phinx 
composer require symfony/yaml
------------------------------------
# for db connection 
composer require ext-pdo
------------------------------------
# for unit test
composer require-dev phpunit/phpunit
------------------------------------
# to make db migrations run the following command:
vendor/bin/phinx migrate

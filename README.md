# Players Guide
------------------------------------

# For db migrations
composer require robmorgan/phinx <br>
composer require symfony/yaml

------------------------------------
# For db connection 
composer require ext-pdo

------------------------------------
# For unit test
composer require-dev phpunit/phpunit

------------------------------------
# To make db migrations run the following command:
vendor/bin/phinx migrate

------------------------------------
# To make unit tests run the following command: (the db should be empty befor run the tests)
./vendor/bin/phpunit test/WaitingListTest.php


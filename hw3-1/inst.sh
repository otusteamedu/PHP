#!/bin/bash
# Xdebug
cd packages/xdebug
curl https://pecl.php.net/get/xdebug-3.0.3.tgz --output xdebug-3.0.3.tgz
tar xvf xdebug-3.0.3.tgz
cd xdebug-3.0.3
phpize
./configure
make > ../../../make_xdebug_output.txt
make install
php -i | grep xdebug > ../../../php_xdebug_output.txt

# Redis
cd ../../redis
curl https://pecl.php.net/get/redis-5.3.3.tgz --output redis-5.3.3.tgz
tar xvf redis-5.3.3.tgz
cd redis-5.3.3
phpize
./configure
make > ../../../make_redis_output.txt
make install
php -i | grep redis > ../../../php_redis_output.txt
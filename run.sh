#!/bin/bash

/usr/local/bin/php server.php &
sleep 1
/usr/local/bin/php client.php -v=lorem
/usr/local/bin/php client.php -v=test
#cat test.txt
/usr/local/bin/php client.php -v=stop

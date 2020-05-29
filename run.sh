#!/bin/bash

/usr/local/bin/php index.php -tserver -cconfig.ini &
sleep 1;
/usr/local/bin/php index.php -tclient -cconfig.ini
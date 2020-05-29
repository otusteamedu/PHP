#!/bin/bash

/usr/local/bin/php index.php -tserver -cconfig.ini &
/usr/local/bin/php index.php -tclient -cconfig.ini
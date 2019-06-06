#!/usr/bin/env bash

docker exec -i otus-mysql sh -c 'exec mysql -uroot -p"$MYSQL_ROOT_PASSWORD" otus -e "call generateData(100)";'
#!/usr/bin/env bash

docker exec -i otus-mysql sh -c 'exec mysql -uroot -p"$MYSQL_ROOT_PASSWORD"' < sql/tables.sql
docker exec -i otus-mysql sh -c 'exec mysql -uroot -p"$MYSQL_ROOT_PASSWORD"' < sql/procedures.sql
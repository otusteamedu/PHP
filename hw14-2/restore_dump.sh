#!/usr/bin/bash

cat percona/sql/dump.sql | docker exec -i otus-percona /usr/bin/mysql -utimofey -ptimofey123 library
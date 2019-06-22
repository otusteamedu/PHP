#!/usr/bin/bash

cat percona/sql/proc.sql | docker exec -i otus-percona /usr/bin/mysql -utimofey -ptimofey123 library
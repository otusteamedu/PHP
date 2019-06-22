#!/usr/bin/bash

echo "CALL generateData(10);" | docker exec -i otus-percona /usr/bin/mysql -utimofey -ptimofey123 library
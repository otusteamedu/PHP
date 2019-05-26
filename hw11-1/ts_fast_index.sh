#!/usr/bin/bash

mkdir /tsFastIndex
chown postgres:postgres /tsFastIndex
psql -U timofey -d cinema -h 127.0.0.1 -c "create tablespace \"tsFastIndex\" location '/tsFastIndex';"
psql -U timofey -d cinema -h 127.0.0.1 -c "alter index all in tablespace pg_default set tablespace \"tsFastIndex\";"
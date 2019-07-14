#!/bin/sh

docker-compose exec postgres pg_dumpall -U user2 -g

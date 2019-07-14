#!/bin/sh

docker-compose exec postgres pg_dump -U user2 -- cinema

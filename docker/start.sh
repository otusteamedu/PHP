#!/usr/bin/env bash

docker-compose -f docker-compose.yml up -d
docker exec -it arukavchuk-app /bin/bash

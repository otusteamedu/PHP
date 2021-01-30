#! /bin/bash

cd /var/www/reles && \
docker-compose -f docker-compose-prod.yml down && \
git reset --hard && \
git pull && \
docker-compose -f docker-compose-prod.yml up -d --build
